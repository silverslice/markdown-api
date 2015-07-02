<?php

namespace Silverslice\MarkdownApi;

use phpDocumentor\Reflection\DocBlock;

class Generator
{
    protected $generatedText;

    /** @var string Path to a template file of a method */
    protected $template = 'template.php';

    /**
     * Generates markdown documentation for public methods in a specified class
     *
     * @param string $className Fully qualified class name
     * @return $this
     */
    public function generate($className)
    {
        $ref = new \ReflectionClass($className);
        $methods = $ref->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if (!$method->isInternal()) {
                $phpdoc = new DocBlock($method->getDocComment());
                //var_dump($phpdoc);
                $signature = $this->getSignature($method);
                $this->generatedText .= $this->render([
                    'name' => $method->getName(),
                    'phpdoc' => $phpdoc,
                    'signature' => $signature
                ]);
            }
        }

        return $this;
    }

    /**
     * Saves generated documentation to a file
     *
     * @param string $fileName The name of the file
     * @return int The number of bytes that were written to the file, or false on failure
     */
    public function save($fileName)
    {
        return file_put_contents($fileName, $this->generatedText);
    }

    /**
     * Outputs generated documentation
     */
    public function output()
    {
        echo $this->generatedText;
    }

    /**
     * Sets file path for template of a method
     *
     * @param string $file Path to the template
     *
     * @throws \InvalidArgumentException If the file cannot be read
     */
    public function setTemplate($file)
    {
        $path = stream_resolve_include_path($file);
        if (!is_readable($path)) {
            throw new \InvalidArgumentException('Template file not found');
        }

        $this->template = $file;
    }

    /**
     * Renders template with params
     *
     * @param array $params
     * @return string
     */
    protected function render(array $params)
    {
        extract($params);
        ob_start();
        include $this->template;

        return ob_get_clean();
    }

    /**
     * Returns signature for the method
     *
     * @param \ReflectionMethod $method
     * @return string
     */
    protected function getSignature(\ReflectionMethod $method)
    {
        $startLine = $method->getStartLine();
        $endLine = $method->getEndLine();
        $lines = $endLine - $startLine + 1;
        $strMethod = '';

        $file = new \SplFileObject($method->getFileName());
        $file->seek($startLine - 2);
        while ($lines) {
            $strMethod .= $file->fgets();
            $lines--;
        }

        $signature = '';
        if (preg_match('#^(.*\))\s*{#sU', $strMethod, $m)) {
            $signature = $m[1];
        }

        // do not cut static keyword
        $signature = trim(preg_replace('#^\s*public\s+(static\s+)?function\s+#', '$1', $signature));

        // replace first indent in multiline signature
        $signature = preg_replace('#^ {4}#m', '', $signature);

        return $signature;
    }
}
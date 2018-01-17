<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parser;

/**
 * Represents a stopwatch node.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Twig_Node_Stopwatch extends \Twig_Node
{
    public function __construct(\Twig_Node $name, $body, \Twig_Node_Expression_AssignName $var, $lineno = 0, $tag = null)
    {
        parent::__construct(array('body' => $body, 'name' => $name, 'var' => $var), array(), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('')
            ->subcompile($this->getNode('var'))
            ->raw(' = ')
            ->subcompile($this->getNode('name'))
            ->write(";\n")
            ->write("\$this->env->getExtension('Parser\Twig_Extension_Stopwatch')->getStopwatch()->start(")
            ->subcompile($this->getNode('var'))
            ->raw(", 'template');\n")
            ->subcompile($this->getNode('body'))
            ->write("\$this->env->getExtension('Parser\Twig_Extension_Stopwatch')->getStopwatch()->stop(")
            ->subcompile($this->getNode('var'))
            ->raw(");\n")
        ;
    }
}
<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * Class Elt
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Elt extends FunctionNode
{
    public $needle   = null;
    public $haystack = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->needle = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->haystack = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'ELT(' .
        $this->needle->dispatch($sqlWalker) . ', ' .
        $this->haystack->dispatch($sqlWalker) .
        ')';
    }
}

<?php

class __Mustache_1b1472e550f12838018b5b58a2182ed1 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="headersearch ';
        $value = $this->resolveValue($context->find('pagelayout'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' d-none d-lg-block float-right">
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('search'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }
}

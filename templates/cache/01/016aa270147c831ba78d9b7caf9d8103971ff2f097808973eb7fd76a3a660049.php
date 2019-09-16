<?php

/* test.twig */
class __TwigTemplate_13a18a7110c39fbdcfd5e31cb017653d2361a69c5ac4311a5632173a52d8950e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <title>test</title>
        <meta name=\"description\" content=\"\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    </head>
    <body style=\"margin-left:400px;margin-right:400px;margin-top:350px;\">
        <!--[if lt IE 7]>
            <p class=\"browsehappy\">You are using an <strong>outdated</strong> browser. Please <a href=\"#\">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <center><h1>Hello there</h1></center>
        
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "test.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "test.twig", "D:\\GRAND_PRO\\PROJECTS\\POSTA_COURIER\\php_server\\POSTA_SCH_SYS\\templates\\test.twig");
    }
}

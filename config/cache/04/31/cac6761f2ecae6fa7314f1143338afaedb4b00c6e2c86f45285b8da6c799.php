<?php

/* home.html */
class __TwigTemplate_0431cac6761f2ecae6fa7314f1143338afaedb4b00c6e2c86f45285b8da6c799 extends Twig_Template
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
<html lang=\"en\" data-ng-app=\"mdbz\" data-ng-controller=\"MainCtrl\" id=\"mdbz\">
<head>
\t<meta charset=\"UTF-8\">
\t<title>MADURA.BZ &mdash; Beranda &mdash; ";
        // line 5
        if (isset($context["member_nama"])) { $_member_nama_ = $context["member_nama"]; } else { $_member_nama_ = null; }
        echo twig_escape_filter($this->env, $_member_nama_, "html", null, true);
        echo "</title>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t
\t";
        // line 9
        $this->env->loadTemplate("pre-page.html")->display($context);
        // line 10
        echo "\t
</head>
<body>
<div class=\"container\">
\t
\t";
        // line 15
        $this->env->loadTemplate("header.html")->display($context);
        // line 16
        echo "\t
\t<div class=\"navbar navbar-default\" style=\"margin-top: 10px;\">
\t\t<div class=\"navbar-header\">
\t\t\t<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-responsive-collapse\">
\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t</button>
\t\t</div>
\t\t<div class=\"navbar-collapse collapse navbar-responsive-collapse\">
\t\t\t<ul class=\"nav navbar-nav\">
\t\t\t\t<li><img src=\"";
        // line 27
        if (isset($context["member_foto"])) { $_member_foto_ = $context["member_foto"]; } else { $_member_foto_ = null; }
        echo twig_escape_filter($this->env, $_member_foto_, "html", null, true);
        echo "\" alt=\"\"></li>
\t\t\t\t<li";
        // line 28
        if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
        if (($_path_ == "")) {
            echo " class=\"active\"";
        }
        echo "><a href=\"/home\">BERANDA</a></li>
\t\t\t\t<li";
        // line 29
        if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
        if (($_path_ == "post")) {
            echo " class=\"active\"";
        }
        echo "><a href=\"/home/post\">KIRIMAN</a></li>\t\t\t\t
\t\t\t\t";
        // line 30
        if (isset($context["member_direktori"])) { $_member_direktori_ = $context["member_direktori"]; } else { $_member_direktori_ = null; }
        if ($_member_direktori_) {
            // line 31
            echo "\t\t\t\t<li";
            if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
            if (($_path_ == "direktori")) {
                echo " class=\"active\"";
            }
            echo "><a href=\"/home/direktori\">DIREKTORI</a></li>\t\t\t\t
\t\t\t\t<li";
            // line 32
            if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
            if (($_path_ == "produk")) {
                echo " class=\"active\"";
            }
            echo "><a href=\"/home/produk\">PRODUK</a></li>
\t\t\t\t";
        }
        // line 34
        echo "\t\t\t\t<li";
        if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
        if (($_path_ == "order")) {
            echo " class=\"active\"";
        }
        echo "><a href=\"/home/order\">PEMESANAN</a></li>\t
\t\t\t</ul>
\t\t</div>
\t</div>
\t
\t<hr class=\"header\">
\t
\t
\t
\t<hr class=\"main\">
\t
\t";
        // line 45
        $this->env->loadTemplate("footer.html")->display($context);
        // line 46
        echo "\t
</div>

";
        // line 49
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 50
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  122 => 50,  120 => 49,  115 => 46,  113 => 45,  95 => 34,  87 => 32,  79 => 31,  76 => 30,  69 => 29,  62 => 28,  57 => 27,  44 => 16,  42 => 15,  35 => 10,  33 => 9,  25 => 5,  19 => 1,);
    }
}

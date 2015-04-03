<?php

/* produk-search.html */
class __TwigTemplate_fdde5172f8b07f251f1cbb4e0eb5b7fba69d311e1dc52ec0cbb9201a5799c01e extends Twig_Template
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
\t<title>MADURA.BZ &mdash; Data Produk</title>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t
\t";
        // line 9
        $this->env->loadTemplate("pre-page.html")->display($context);
        // line 10
        echo "
</head>
<body>

<div class=\"container\">
\t
\t";
        // line 16
        $this->env->loadTemplate("header.html")->display($context);
        // line 17
        echo "\t
\t<hr class=\"header\">
\t
\t<div class=\"row\">
\t\t<div class=\"col-md-4\">
\t\t\t<h5 class=\"text-muted\" style=\"letter-spacing: 5px;\">
\t\t\t\t<i class=\"fa fa-gift\"></i> PRODUK
\t\t\t</h5>
\t\t</div>
\t\t<div class=\"col-md-8\">
\t\t\t<form class=\"form-inline pull-right\" action=\"/fproduk\">
\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t<label for=\"query\" class=\"sr-only\">Pencarian</label>
\t\t\t\t\t<input type=\"text\" name=\"query\" id=\"query\" class=\"form-control\" value=\"";
        // line 30
        if (isset($context["param"])) { $_param_ = $context["param"]; } else { $_param_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_param_, "query", array()), "html", null, true);
        echo "\" style=\"width: 200px;\">
\t\t\t\t\t
\t\t\t\t\t<label for=\"kategori\" class=\"sr-only\">Kategori</label>
\t\t\t\t\t<select name=\"kategori\" id=\"kategori\" class=\"form-control\" style=\"width: 200px;\" value=\"";
        // line 33
        if (isset($context["param"])) { $_param_ = $context["param"]; } else { $_param_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_param_, "kategori", array()), "html", null, true);
        echo "\">
\t\t\t\t\t\t<option value=\"\">-- kategori --</option>
\t\t\t\t\t\t";
        // line 35
        if (isset($context["kategori"])) { $_kategori_ = $context["kategori"]; } else { $_kategori_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_kategori_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 36
            echo "\t\t\t\t\t\t<option value=\"";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "id", array()), "html", null, true);
            echo "\"";
            if (isset($context["param"])) { $_param_ = $context["param"]; } else { $_param_ = null; }
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_param_, "kategori", array()) == $this->getAttribute($_c_, "id", array()))) {
                echo " selected";
            }
            echo ">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "nama", array()), "html", null, true);
            echo "</option>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "\t\t\t\t\t</select>
\t\t\t\t\t
\t\t\t\t\t<button class=\"btn btn-default\"><i class=\"fa fa-search\"></i> CARI</button>
\t\t\t\t</div>
\t\t\t</form>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t<div class=\"col-md-12\">
\t\t<div class=\"panel panel-default\">
\t\t\t<div class=\"panel-body\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t<a href=\"\" class=\"btn btn-default pull-right\"><i class=\"fa fa-download\"></i> UNDUH KATALOG</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\" style=\"margin-bottom: 40px; margin-top: 10px;\">
\t\t\t\t\t";
        // line 55
        if (isset($context["produk"])) { $_produk_ = $context["produk"]; } else { $_produk_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_produk_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 56
            echo "\t\t\t\t\t<div class=\"col-md-4\">
\t\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t\t<a class=\"media-left\" href=\"";
            // line 58
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t<img src=\"";
            // line 59
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\" class=\"img-rounded\" width=\"65px\">
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t\t<h4 class=\"media-heading\">
\t\t\t\t\t\t\t\t\t<a href=\"";
            // line 63
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "nama", array()), "html", null, true);
            echo "</a>
\t\t\t\t\t\t\t\t\t";
            // line 64
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_c_, "stok", array()) > 0)) {
                echo "<small class=\"label label-warning pull-right\" style=\"font-size: 0.67em\">TERSEDIA</small>";
            }
            // line 65
            echo "\t\t\t\t\t\t\t\t\t";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_c_, "stok", array()) == 0)) {
                echo "<small class=\"label label-danger pull-right\" style=\"font-size: 0.67em\">TERJUAL</small>";
            }
            // line 66
            echo "\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\t\t";
            // line 68
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "info", array()), "html", null, true);
            echo "<br><br>
\t\t\t\t\t\t\t\t\t<span class=\"text-muted\"><i class=\"fa fa-tag\"></i> ";
            // line 69
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "kategori", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t<strong class=\"label label-success pull-right\" style=\"font-size: 1em;\">Rp. ";
            // line 70
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "harga", array()), "html", null, true);
            echo "</strong>
\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t\t\t";
            // line 73
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_c_, "stok", array()) > 0)) {
                // line 74
                echo "\t\t\t\t\t\t\t\t\t<button class=\"btn btn-primary btn-xs pull-right\" data-ng-click=\"addItem(";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "id", array()), "html", null, true);
                echo ")\" data-ng-hide=\"itemTaken(";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "id", array()), "html", null, true);
                echo ")\">TAMBAH KE KERANJANG <i class=\"fa fa-cart-plus\"></i></button>
\t\t\t\t\t\t\t\t\t";
            }
            // line 76
            echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 81
        echo "\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"panel-footer text-center\">
\t\t\t\t";
        // line 84
        if (isset($context["produk"])) { $_produk_ = $context["produk"]; } else { $_produk_ = null; }
        if ($_produk_) {
            // line 85
            echo "\t\t\t\t<ul class=\"pagination pagination-sm\" style=\"margin: 10px 0;\">
\t\t\t\t\t<li";
            // line 86
            if (isset($context["cpage"])) { $_cpage_ = $context["cpage"]; } else { $_cpage_ = null; }
            if (($_cpage_ == 0)) {
                echo " class=\"disabled\"";
            }
            echo "><a href=\"/fproduk?";
            if (isset($context["link"])) { $_link_ = $context["link"]; } else { $_link_ = null; }
            echo twig_escape_filter($this->env, $_link_, "html", null, true);
            echo "&cpage=0\">&laquo;</a></li>
\t\t\t\t\t";
            // line 87
            if (isset($context["numpage"])) { $_numpage_ = $context["numpage"]; } else { $_numpage_ = null; }
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable(range(0, ($_numpage_ - 1)));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 88
                echo "\t\t\t\t\t<li";
                if (isset($context["cpage"])) { $_cpage_ = $context["cpage"]; } else { $_cpage_ = null; }
                if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
                if (($_cpage_ == $this->getAttribute($_loop_, "index0", array()))) {
                    echo " class=\"active\"";
                }
                echo "><a href=\"/fproduk?";
                if (isset($context["link"])) { $_link_ = $context["link"]; } else { $_link_ = null; }
                echo twig_escape_filter($this->env, $_link_, "html", null, true);
                echo "&cpage=";
                if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index0", array()), "html", null, true);
                echo "\">";
                if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index", array()), "html", null, true);
                echo " <span class=\"sr-only\">(current)</span></a></li>
\t\t\t\t\t";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 90
            echo "\t\t\t\t\t<li";
            if (isset($context["cpage"])) { $_cpage_ = $context["cpage"]; } else { $_cpage_ = null; }
            if (isset($context["numpage"])) { $_numpage_ = $context["numpage"]; } else { $_numpage_ = null; }
            if (($_cpage_ == ($_numpage_ - 1))) {
                echo " class=\"disabled\"";
            }
            echo "><a href=\"/fproduk?";
            if (isset($context["link"])) { $_link_ = $context["link"]; } else { $_link_ = null; }
            echo twig_escape_filter($this->env, $_link_, "html", null, true);
            echo "&cpage=";
            if (isset($context["numpage"])) { $_numpage_ = $context["numpage"]; } else { $_numpage_ = null; }
            echo twig_escape_filter($this->env, ($_numpage_ - 1), "html", null, true);
            echo "\">&raquo;</a></li>
\t\t\t\t</ul>
\t\t\t\t";
        }
        // line 93
        echo "\t\t\t</div>
\t\t</div>
\t</div>
\t
\t<hr class=\"main\">
\t
\t";
        // line 99
        $this->env->loadTemplate("footer.html")->display($context);
        // line 100
        echo "
</div>

";
        // line 103
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 104
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "produk-search.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  300 => 104,  298 => 103,  293 => 100,  291 => 99,  283 => 93,  266 => 90,  236 => 88,  218 => 87,  208 => 86,  205 => 85,  202 => 84,  197 => 81,  187 => 76,  177 => 74,  174 => 73,  167 => 70,  162 => 69,  157 => 68,  153 => 66,  147 => 65,  142 => 64,  134 => 63,  126 => 59,  121 => 58,  117 => 56,  112 => 55,  93 => 38,  74 => 36,  69 => 35,  63 => 33,  56 => 30,  41 => 17,  39 => 16,  31 => 10,  29 => 9,  19 => 1,);
    }
}

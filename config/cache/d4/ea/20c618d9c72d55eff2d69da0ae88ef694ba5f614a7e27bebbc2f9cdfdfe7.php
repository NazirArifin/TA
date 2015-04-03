<?php

/* home-post.html */
class __TwigTemplate_d4ea20c618d9c72d55eff2d69da0ae88ef694ba5f614a7e27bebbc2f9cdfdfe7 extends Twig_Template
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
<script>
\twindow.member = '";
        // line 12
        if (isset($context["member_kode"])) { $_member_kode_ = $context["member_kode"]; } else { $_member_kode_ = null; }
        echo twig_escape_filter($this->env, $_member_kode_, "html", null, true);
        echo "';
\twindow.valid = '";
        // line 13
        if (isset($context["member_valid"])) { $_member_valid_ = $context["member_valid"]; } else { $_member_valid_ = null; }
        echo twig_escape_filter($this->env, $_member_valid_, "html", null, true);
        echo "';
</script>
\t
</head>
<body>
<div class=\"container\">
\t
\t";
        // line 20
        $this->env->loadTemplate("header.html")->display($context);
        // line 21
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
        // line 32
        if (isset($context["member_foto"])) { $_member_foto_ = $context["member_foto"]; } else { $_member_foto_ = null; }
        echo twig_escape_filter($this->env, $_member_foto_, "html", null, true);
        echo "\" alt=\"\"></li>
\t\t\t\t<li";
        // line 33
        if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
        if (($_path_ == "")) {
            echo " class=\"active\"";
        }
        echo "><a href=\"/home\">BERANDA</a></li>
\t\t\t\t<li";
        // line 34
        if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
        if (($_path_ == "post")) {
            echo " class=\"active\"";
        }
        echo "><a href=\"/home/post\">KIRIMAN</a></li>\t\t\t\t
\t\t\t\t";
        // line 35
        if (isset($context["member_direktori"])) { $_member_direktori_ = $context["member_direktori"]; } else { $_member_direktori_ = null; }
        if ($_member_direktori_) {
            // line 36
            echo "\t\t\t\t<li";
            if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
            if (($_path_ == "direktori")) {
                echo " class=\"active\"";
            }
            echo "><a href=\"/home/direktori\">DIREKTORI</a></li>\t\t\t\t
\t\t\t\t<li";
            // line 37
            if (isset($context["path"])) { $_path_ = $context["path"]; } else { $_path_ = null; }
            if (($_path_ == "produk")) {
                echo " class=\"active\"";
            }
            echo "><a href=\"/home/produk\">PRODUK</a></li>
\t\t\t\t";
        }
        // line 39
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
\t";
        // line 170
        echo "
\t<div class=\"row\" data-ng-controller=\"HomePostCtrl\" data-ng-cloak>
\t\t<div class=\"col-md-12\" data-ng-hide=\"editing\">
\t\t\t<h5 style=\"width: 100%\">
\t\t\t\tDATA KIRIMAN
\t\t\t\t<a href=\"\" class=\"btn btn-info pull-right\" data-ng-click=\"editing = true\"><i class=\"fa fa-plus-circle fa-lg\"></i> Kirim Baru</a>
\t\t\t</h5>
\t\t\t<br>
\t\t\t<div data-ng-show=\"dataList\">
\t\t\t\t<div class=\"table-responsive\">
\t\t\t\t\t<table class=\"table table-condensed table-striped table-hover\">
\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t<tr data-ng-repeat=\"c in dataList\">
\t\t\t\t\t\t\t\t<td style=\"padding-top: 18px;\"><strong class=\"label\" data-ng-class=\"c.tipe == 'jual' ? 'label-success' : 'label-info'\">{{c.tipe|uppercase}}</strong></td>
\t\t\t\t\t\t\t\t<td><a data-ng-href=\"{{c.link}}\"><img data-ng-src=\"{{c.foto}}\" alt=\"\" class=\"dirsearch-img\"></a></td>
\t\t\t\t\t\t\t\t<td style=\"padding-top: 15px\">
\t\t\t\t\t\t\t\t\t<a data-ng-href=\"{{c.link}}\" style=\"font-size: 1.2em; line-height: 1.4em;\">{{c.judul}}</a><br>
\t\t\t\t\t\t\t\t\t<small class=\"text-muted\" style=\"font-size: 0.87em\">
\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-comments\"></i> {{c.komentar}} &nbsp; 
\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-calendar\"></i> {{c.tanggal}}
\t\t\t\t\t\t\t\t\t</small> 
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td style=\"padding-top: 10px; width: 60%;\"><p>{{c.isi}}</p></td>
\t\t\t\t\t\t\t\t<td style=\"padding-top: 18px;\">
\t\t\t\t\t\t\t\t\t<span class=\"btn-group\">
\t\t\t\t\t\t\t\t\t\t<a href=\"\" class=\"btn btn-default btn-sm\" data-ng-click=\"setEdit(c.id)\"><i class=\"fa fa-pencil-square\"></i></a>
\t\t\t\t\t\t\t\t\t\t<a href=\"\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-trash-o\"></i></a>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t</tbody>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t\t<ul class=\"pagination pagination-sm pull-right\" data-ng-show=\"dataList\">
\t\t\t\t\t<li data-ng-class=\"{ disabled: cpage == 0 }\">
\t\t\t\t\t\t<a href=\"\" data-ng-click=\"prevPage()\"><i class=\"fa fa-chevron-left\"></i></a>
\t\t\t\t\t</li>
\t\t\t\t\t<li data-ng-repeat=\"n in range(numpage)\" data-ng-class=\"{ active: n == cpage }\">
\t\t\t\t\t\t<a href=\"\" data-ng-click=\"setPage()\" data-ng-bind=\"n + 1\">1</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li data-ng-class=\"{ disabled: cpage == numpage - 1 }\">
\t\t\t\t\t\t<a href=\"\" data-ng-click=\"nextPage()\"><i class=\"fa fa-chevron-right\"></i></a>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<div data-ng-hide=\"dataList\">
\t\t\t\t<div class=\"well\">
\t\t\t\t\t<h3 class=\"text-center text-info\"><i class=\"fa fa-file-o\"></i> Belum ada Data</h3>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"col-md-12\" data-ng-show=\"editing\">
\t\t\t<h5 style=\"width: 100%\">
\t\t\t\tTAMBAH DATA KIRIMAN
\t\t\t\t<a href=\"\" class=\"btn btn-default pull-right\" cancel-form><i class=\"fa fa-chevron-circle-left fa-lg\"></i> Batalkan</a>
\t\t\t</h5>
\t\t\t<br>
\t\t\t<hr class=\"main\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-9\">
\t\t\t\t\t<form class=\"form-horizontal\" role=\"form\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<label for=\"tipe\" class=\"col-lg-3 control-label\">JENIS KIRIMAN</label>
\t\t\t\t\t\t\t<div class=\"col-lg-4\">
\t\t\t\t\t\t\t\t<div class=\"radio\">
\t\t\t\t\t\t\t\t\t<label><input type=\"radio\" name=\"tipe\" id=\"tipe-jual\" value=\"1\" data-ng-model=\"data.tipe\"> JUAL</label> &nbsp; 
\t\t\t\t\t\t\t\t\t<label><input type=\"radio\" name=\"tipe\" id=\"tipe-jual\" value=\"2\" data-ng-model=\"data.tipe\"> BELI</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<label for=\"judul\" class=\"col-lg-3 control-label\">JUDUL *</label>
\t\t\t\t\t\t\t<div class=\"col-lg-9\">
\t\t\t\t\t\t\t\t<input type=\"text\" name=\"judul\" id=\"judul\" maxlength=\"80\" class=\"form-control\" placeholder=\"Judul Kiriman\" data-ng-model=\"data.judul\">
\t\t\t\t\t\t\t\t<span class=\"help-block\"><em><small class=\"text-muted\">sebaiknya unik, singkat dan deskriptif</small></em></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<label for=\"isi\" class=\"col-lg-3 control-label\">ISI KIRIMAN *</label>
\t\t\t\t\t\t\t<div class=\"col-lg-9\">
\t\t\t\t\t\t\t\t<textarea name=\"isi\" id=\"isi\" cols=\"30\" rows=\"10\" class=\"form-control\" data-ng-model=\"data.isi\"></textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\" data-ng-show=\"data.foto.length > 0\">
\t\t\t\t\t\t\t<div class=\"col-lg-12 gallery-photos-wrapper\">
\t\t\t\t\t\t\t\t<ul id=\"gallery-photos\" class=\"clearfix gallery-photos gallery-photos-hover\" sortable data-type=\"data\">
\t\t\t\t\t\t\t\t\t<li id=\"foto_{{getFotoId(c)}}\" class=\"col-md-2 col-sm-3 col-xs-6\" data-ng-repeat=\"c in data.foto\">
\t\t\t\t\t\t\t\t\t\t<div class=\"photo-box\" style=\"background-image: url('{{c}}');\"></div>
\t\t\t\t\t\t\t\t\t\t<a href=\"\" class=\"remove-photo-link\" data-type=\"data\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"fa-stack fa-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-circle fa-stack-2x\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-trash-o fa-stack-1x fa-inverse\"></i>
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<label for=\"\" class=\"col-lg-3 control-label\">FOTO *</label>
\t\t\t\t\t\t\t<div class=\"col-lg-9\">
\t\t\t\t\t\t\t\t<span class=\"btn btn-success btn-sm btn-file\">
\t\t\t\t\t\t\t\t\t<span><i class=\"fa fa-file-o\"></i> Pilih Berkas</span>
\t\t\t\t\t\t\t\t\t<input type=\"file\" name=\"file\" id=\"file\" accept=\".png,.jpg,.jpeg\" multiple simple-file-input>
\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t<span class=\"help-block\"><em><small class=\"text-muted\">format file jpg, jpeg, png, maksimal berukuran 2 MB, Anda dapat memilih hingga {{maxUpload}} file, <strong class=\"text-warning\">file lama akan tertindih</strong> bila lebih dari {{maxUpload}}</small></em></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"col-lg-9 col-lg-offset-3\">
\t\t\t\t\t\t\t\t<button class=\"btn btn-primary\" save-kiriman><i class=\"fa fa-check\"></i> SIMPAN KIRIMAN</button> 
\t\t\t\t\t\t\t\t<a href=\"\" class=\"btn btn-default\" cancel-form>BATALKAN</a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</form>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-3\">
\t\t\t\t\t<div class=\"well well-sm\"></div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t
\t";
        echo "
\t
\t<hr class=\"main\">
\t
\t";
        // line 174
        $this->env->loadTemplate("footer.html")->display($context);
        // line 175
        echo "\t
</div>

";
        // line 178
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 179
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "home-post.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  262 => 179,  260 => 178,  255 => 175,  253 => 174,  122 => 170,  108 => 39,  100 => 37,  92 => 36,  89 => 35,  82 => 34,  75 => 33,  70 => 32,  57 => 21,  55 => 20,  44 => 13,  39 => 12,  35 => 10,  33 => 9,  25 => 5,  19 => 1,);
    }
}

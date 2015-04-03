<?php

/* post-page.html */
class __TwigTemplate_077606aa416234edfbea9b10e683a7efbed582041a02b7cd3feb3e8ac0fd3853 extends Twig_Template
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
        echo "<!-- Modal -->
<div class=\"modal fade\" id=\"login\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
\t<div class=\"modal-dialog\">
\t\t<div class=\"modal-content\">
\t\t\t<form method=\"post\" action=\"/login\">
\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
\t\t\t\t<h4 class=\"modal-title\">
\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-unlock fa-stack-1x fa-inverse\"></i></span> 
\t\t\t\t\tMASUK SITUS
\t\t\t\t</h4>
\t\t\t</div>
\t\t\t<div class=\"modal-body\">
\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t<label for=\"email\">Alamat email</label>
\t\t\t\t\t<input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" placeholder=\"Masukkan Email\">
\t\t\t\t</div>
\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t<label for=\"pass\">Password</label>
\t\t\t\t\t<input type=\"password\" class=\"form-control\" name=\"password\" id=\"pass\" placeholder=\"Password\">
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"modal-footer\">
\t\t\t\t<button type=\"submit\" class=\"btn btn-default\"><strong><i class=\"fa fa-key\"></i> MASUK</strong></button>
\t\t\t</div>
\t\t\t</form>
\t\t</div>
\t</div>
</div>

<!-- modal untuk mengirim pesan -->
<div class=\"md-modal md-effect-5\" id=\"modal-2\">
\t<div class=\"md-content\">
\t\t<div class=\"modal-header\">
\t\t\t<button class=\"md-close close\">&times;</button>
\t\t\t<h4 class=\"modal-title\">Kirim Pesan</h4>
\t\t</div>
\t\t<div class=\"modal-body\">
\t\t\t<div class=\"container-fluid\">
\t\t\t\t<form role=\"form\" class=\"form-horizontal\">
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<label for=\"modalInputFor\" class=\"col-md-3 control-label\">Penerima</label>
\t\t\t\t\t\t<div class=\"col-md-8\">
\t\t\t\t\t\t\t<input type=\"text\" name=\"for\" id=\"modalInputFor\" class=\"form-control\" data-ng-model=\"message.forName\" disabled>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<label for=\"modalInputText\" class=\"col-md-3 control-label\">Pesan<br><small class=\"text-muted\"><span class=\"type-maximal-counter\">160</span> karakter tersisa</small></label>
\t\t\t\t\t\t<div class=\"col-md-8\">
\t\t\t\t\t\t\t<textarea name=\"\" id=\"modalInputText\" cols=\"30\" rows=\"4\" class=\"form-control\" data-ng-model=\"message.message\" data-ng-focus=\"message.message.length == 0\" type-maximal=\"160\"></textarea>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"modal-footer\">
\t\t\t<button type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-close\"></i> BATAL</button>
\t\t\t<button type=\"button\" class=\"btn btn-primary\" id=\"message-send\" save-message-modal><i class=\"fa fa-send\"></i> KIRIMKAN</button>
\t\t</div>
\t</div>
</div>
<!-- akhir modal -->

<div class=\"md-overlay\"></div><!-- the overlay element -->

<script src=\"/js/bootstrap.min.js\"></script>
<script src=\"/js/jquery-ui.custom.min.js\"></script>
<script src=\"/js/helper.min.js\"></script>
<script src=\"/js/tools.min.js\"></script>

<script src=\"/js/custom/app.js\"></script>
<script src=\"/js/custom/directive.js\"></script>
<script src=\"/js/custom/directive-form.js\"></script>
<script src=\"/js/custom/main-ctrl.js\"></script>";
    }

    public function getTemplateName()
    {
        return "post-page.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}

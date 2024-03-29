<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Mvc\Controllers\AdminController;

class ResourceManagerController extends AdminController
{
    public function indexAction()
    {
        $this->assets->collection('head')->addJs('assets/jquery/dist/jquery.min.js');
        $this->assetsCollection->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-buttons-dt/css/buttons.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-select-dt/css/select.dataTables.min.css');
        $this->assetsCollection->addCss('dt/css/editor.dataTables.min.css');


//        $this->assetsCollection->addJs('ilya-theme/dashboard/assets/js/event-show-hide.js');


        $this->assetsCollection->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-buttons/js/dataTables.buttons.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-select/js/dataTables.select.min.js');

        $this->assetsCollection->addJs('assets/select2/dist/js/select2.min.js');
        $this->assetsCollection->addCss('assets/select2/dist/css/select2.min.css');
        $this->assetsCollection->addJs('dt/js/editor.select2.js');
        $this->assetsCollection->addJs('https://cdn.ckeditor.com/4.11.4/full/ckeditor.js', false);
        $this->assetsCollection->addJs('dt/js/editor.ckeditor.js');
        $this->assetsCollection->addJs('dt/js/dataTables.editor.min.js');

//        $this->assetsCollection->addJs($this->config->module->path. '/views/resource-manager/category-editor.js', null, true, ['cache' => false]);
//        $this->assetsCollection->addJs($this->config->module->path. '/views/resource-manager/category-table.js', null, true, ['cache' => false]);
//        $this->assetsCollection->addJs($this->config->module->path.'/views/resource-manager/resources-editor.js', null,
//            true, ['cache' => false]);
//        $this->assetsCollection->addJs($this->config->module->path.'/views/resource-manager/resources-table.js', null,
//            true, ['cache' => false]);
//        $this->assetsCollection->addJs($this->config->module->path.'/views/resource-manager/roles-editor.js', null,
//            true, ['cache' => false]);
//        $this->assetsCollection->addJs($this->config->module->path.'/views/resource-manager/roles-table.js', null,
//            true, ['cache' => false]);

        $this->assetsCollection->addJs($this->config->module->path. '/views/resource-manager/resource-manager.js', null, true, ['cache' => false]);

        // css rtl editor modal
        $this->assetsCollection->addInlineCss(/** @lang CSS */
            <<<TAG
            div.DTE_Body div.DTE_Body_Content div.DTE_Field>label {
                direction: rtl;
                float: right;
                text-align: right;
            }
TAG
);
        // css for tree view datatable
        $this->assetsCollection->addInlineCss(/** @lang CSS */
            <<<TAG
            td.details-control {
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABGdBTUEAANbY1E9YMgAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAMDSURBVHjarFXdS5NRGH/eufyK2ZZWvqKiyZQQpQ9hNKVIHZLzpq7Ey8SbQhG66R+IPqCuCqKLrsK8kbCMhcOwNdimglZ24WSVHyxzVjqZQ9+P0/Mcz1upE7vwjB/nnOfjt3Oej/NKkHqYEGmIA4h0saahITYQiljr2x2lFHszIgthQeQgDgpSEGQJRByxikgiVARLdSoiy0QcRVR2dHRc8fv9nmg0OqvrukagNclIRzbCNjPFwbiATlWAcPT39z9VFGWD7TJIRzZkK3y2kEriSvmyLJ+LRCIfySmpJZk3Nsiuf+pmLaGLrDnYxLonO9mr7wMsoSY4MdmSD/oeExySJBJAsSoOBoN3HQ5H07KyDI+/PoI3S0M8OGTEpM1I0VR7uA6ull6D3PQ8CAQCHqfTeQPFMxRXI5O2rq6uhvb29k4NNOlO+DYMx4bRH386gv0DXYeZ5AxE1iJw4Ug9FBcWl8VisYnR0dFZSpJJEB5qbW29JEmS6d2SD3wxH2gaUmsqqLoG3roh8NYO8T1mB1TUjf0Yg7f4p+TT1tZ2WdzSbBBml5eXn6SAeqKvQVWRTFdBUdFZVf9kjuRch4QKknu+ebi8oqKCfLMpjmZRtOlWqzWXlFPxKXRQ8LISBFyBLaXgq/fz2ek9y+fPq1/4bLFYrEYDmLfXD8WMTrazsv4OVVN5qtaVjc0ywWsbOrPRTvF4/JfNZsuTM2SYW53nKT01cJrP4y3j3NjYi7xDQU4Bl6PvT9FFmkn05Vo4HJ4gpSvfxeO2GS+VJ8AYioghnZDWjXIjl09PT38gDjIxCFd6enr6sCz05sJmqLJWcSIOdDzRV8nBsy5kdosdWorcVEp6b2/vc9HfSppxh1AoFHe73faSopKyM3k1EF4J49XnttSizvgOqm3VcKvmJsjZMoyMjAxibz9Bjph4LFK33mJykT2YfMgaXrrY8Wd2Voo4/6Ke3Xt/n0UT0e2tl2+03n49Dlm7vTg7nq+FhYV5g4jWez1f//vAZgj9+l4PrLTfn4DfAgwAXP8AAdHdgRsAAAAASUVORK5CYII=') no-repeat center center;
            cursor: pointer;
            background-origin:content-box;
        }
        tr.details td.details-control {
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABGdBTUEAANbY1E9YMgAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAALbSURBVHjarFVNTFNBEJ4tFVuw0gaj1Jhe5OdgJV5Iaw+CGAMKIdET4Sgh4SIHDcYLN07oiZOGqyFcjOECISEhwRpoGxLExAMVAi9NadIgWNLW8t7bdWa7L0Ap6oFtvsy+3Zlvd2ZnpnYoP2yICsQFRKWa0zARhwhdzXmpob3km6k1J8KFuIyoVqSgyLKIDOIAkUcYCFHuVkTmQFxF3BoYGHgWDodnk8mkxjk3CTSnNdojHaXrULanyOhW1xGB6enpD7quH4ozBu2RDukqmxOkTLlU5/V6721sbHwjI57Pi9z8vNgdHhY7PT0i1d0tdl+8FNmZGcGzWUlMumSDttcUB2PqAShWvuXl5bFAINDB9/chMzEBuYWF4rGMgsSACQECTRyhENQMDkJFbS0sLS3NhkKh16i1TXG1XtIzNDT0oL+//zmYJtt7Mwa5xc+Al0AmDlwKJKMfrunaNhibm+Bsa4MbPt/NdDq9GovFNHokmyKs6e3tfcIYs+XDYciGvwA3TQnT5EXJaW6qdQ65lRU8dBHIpq+v76ny0m4RVjU2Nt4h7w7m5qRhKY4OOALp0mhqaiLbKoqjXSVtpdvtrqXNfDwuldE3qMcblBs/WlulLGxtSelyudxWAZQmtkx90zTgb8M0DPlQTNeLaYJuH68UWU6ZTGbP4/FcqfB64XciIZ/2e/CuSixVCMeErAJvnfxG25+qikybqsvc+vr6qrx+e7uKkXEEQ8WNcxXPorx0v10SxuPxNeIgLovw1+Tk5EfKZ3dHBzj8/qIxt0gUkUWMh1TW14Pn8SNKIz41NfVJ1bd+IrGj0ejblpaWhwVNA210FA6iEfSPFV203EZnq5ubwTcyAs6GBohEInPBYPAVbmiKtHzpHabTIvnuvVjr6hIx/20R9fvF185OkRgfF4WdndLSq7NK77yag/OsjnOqfaVSqYRFRPN/tS/2nw32otov/KvBsvP+C/gjwAC23ACdhngbNwAAAABJRU5ErkJggg==') no-repeat center center;
            background-origin:content-box;
        }
        td.details-control.level-1 {
            padding-right:30px;
        }
        tr.details td.details-control.level-1 {
            padding-right:30px;
        }
        td.details-control.level-2 {
            padding-right:50px;
        }
        td.details-control.level-3 {
            padding-right:70px;
        }
        td.details-control.level-4 {
            padding-right:90px;
        }
        tr.details td.details-control.level-2 {
            padding-right:50px;
        }
        tr.details td.details-control.level-3 {
            padding-right:70px;
        }
        tr.details td.details-control.level-4 {
            padding-right:90px;
        }
        td.details-control.level-5 {
            padding-right:110px;
        }
        td.details-control.level-6 {
            padding-right:130px;
        }
        td.details-control.level-7 {
            padding-right:150px;
        }
        tr.details td.details-control.level-5 {
            padding-right:110px;
        }
        tr.details td.details-control.level-6 {
            padding-right:130px;
        }
        tr.details td.details-control.level-7 {
            padding-right:150px;
        }
TAG
);
    }
}
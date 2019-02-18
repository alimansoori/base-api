<?php
namespace Lib\Tables\Adapter;


use Lib\Exception;
use Lib\Tables\Column;
use Modules\System\Native\Models\Language\ModelLanguage;

abstract class TreeViewTable extends HierarchyTable
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->columnDetailsControl();
    }

    public function processEvents()
    {
        $this->eventTreeView();
        parent::processEvents();
    }

    private function columnDetailsControl()
    {
        $column = new Column('details_control');
        $column->setData(null);
        $column->setClassName('dt-center details-control');
        $column->setOrderable(false);
        $column->setDefaultContent('');
        $column->setWidth('10px');
        $column->setCreatedCell("||
        function(td, cellData, rowData, row, col) { 
            if (rowData.level > 0) {
                td.className = td.className + ' child-'+rowData.child +' level-' + rowData.level; 
            }
            if (typeof rowData.child !== 'undefined' && rowData.child > 0) {
                var tr = td.closest('tr');
                $(tr).addClass('details');
            } 
        }||");
        $this->addColumn($column);
    }

    private function eventTreeView()
    {
        if (!$this->hasColumn('parent_id'))
        {
            throw new Exception('Target parent id is required');
        }

        $parentTarget = $this->getColumn('parent_id')->getTarget();

        if (ModelLanguage::getCurrentDir() == 'rtl')
        {
            $this->assetsManager->addInlineCss(<<<TAG
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
        tr.details td.details-control.level-2 {
            padding-right:50px;
        }
        tr.details td.details-control.level-3 {
            padding-right:70px;
        }
        tr.details td.details-control.level-4 {
            padding-right:90px;
        }
TAG
            );
        }
        else
        {
            $this->assetsManager->addInlineCss(<<<TAG
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
            padding-left:30px;
        }
        tr.details td.details-control.level-1 {
            padding-left:30px;
        }
        td.details-control.level-2 {
            padding-left:50px;
        }
        tr.details td.details-control.level-2 {
            padding-left:50px;
        }
        tr.details td.details-control.level-3 {
            padding-left:70px;
        }
        tr.details td.details-control.level-4 {
            padding-left:90px;
        }
TAG
            );
        }

        $this->assetsManager->addInlineJsBottom(<<<TAG
        var displayed = new Set([]);
         $('#{$this->getName()} tbody').on('click', 'tr td:first-child', function() {
          var tr = $(this).closest('tr');
          var row = {$this->getName()}.row(tr);
          var id = row.data().id;
          if (displayed.has(id)) {
           displayed.delete(id);
           tr.removeClass('details');
          } else {
           displayed.add(id);
           tr.addClass('details');
          }
          var regex = "^(0";
          displayed.forEach(function(value) {
           regex = regex + "|" + value;
          });
          regex = regex + ")$";
          {$this->getName()}.columns([{$parentTarget}]).search(regex, true, false).draw();
         });
TAG
);

        $this->events->onInit(<<<TAG
        {$this->getName()}.columns([$parentTarget]).search('^(0)$', true, false).draw();
TAG
);
    }
}
@extends('layouts.master')

@section('og')
@stop

@section('title')
objednávka | 
@parent
@stop

@section('content')

<section class="collection content-section top-section">
    <div class="collection-body">
        <div class="container">
            <div class="row">
                @if (Session::has('message'))
                    <div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{ Session::get('message') }}</div>
                @endif
                @if (strtotime('now') < strtotime('2015-12-24'))
                    <div class="alert alert-warning text-center" role="alert">Predvianočné objednávky tlačených reprodukcií boli už uzavreté. Vaša objednávka bude vybavená najskôr v januári 2016.</div>
                @endif
                <div class="col-md-8 col-md-offset-2 text-center">
                    	<h2 class="bottom-space">Objednávka</h2>
                        <p>K vybraným dielam zo zbierok SNG ponúkame možnosť objednať si reprodukcie v archívnej kvalite na fineartových papieroch. Po výbere diel, vyplnení údajov a odoslaní objednávky vás bude kontaktovať pracovník SNG s podrobnejšími informáciami. 
                        Momentálne je možné vyzdvihnúť si diela len osobne v&nbsp;kníhkupectve <a href="https://goo.gl/maps/3Uf4S" target="_blank" class="underline">Ex Libris v priestoroch SNG na Námestí Ľ. Štúra 4 v Bratislave</a>  alebo v pokladni <a href="https://goo.gl/maps/MPRy6Qdwm8s" target="_blank" class="underline">Zvolenského zámku - Námestie SNP 594/1</a>. </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="order content-section">
        <div class="container">
            <div class="row">
            	<div class="col-xs-12">
            		<!-- <h3>Diela: </h3> -->


{{
  Former::open('objednavka')->class('form-bordered form-horizontal')->id('order')->rules(Order::$rules);
}}

<div class="form-group required has-feedback"><label for="pids" class="control-label col-lg-2 col-sm-4">Diela objednávky</label>
    <div class="col-lg-10 col-sm-8">
            @if ($items->count() == 0)
                <p class="text-center">Nemáte v košíku žiadne diela</p>
            @endif

            @foreach ($items as $i=>$item)
                <div class="media">
                    <a href="{{ $item->getUrl() }}" class="pull-left">
                        <img src="{{ $item->getImagePath() }}" class="media-object" style="max-width: 80px; ">
                    </a>
                    <div class="media-body">                           
                        <a href="{{ $item->getUrl() }}">
                            <em>{{ implode(', ', $item->authors) }}</em> <br> <strong>{{ $item->title }}</strong> (<em>{{ $item->getDatingFormated() }}</em>)
                        </a><br>
                        <p class="item"><a href="{{ URL::to('dielo/' . $item->id . '/odstranit') }}" class="underline"><i class="fa fa-times"></i> odstrániť</a></span>
                        @if (empty($item->iipimg_url))
                            <br><span class="bg-warning">Toto dielo momentálne nemáme zdigitalizované v dostatočnej kvalite, vybavenie objednávky preto môže trvať dlhšie ako zvyčajne.</span>
                        @endif
                    </div>
                </div>
            @endforeach                    
    </div>
</div>

{{ Former::hidden('pids')->value(implode(', ', Session::get('cart',array()))); }}
{{ Former::text('name')->label('Meno')->required(); }}
{{ Former::text('address')->label('Adresa'); }}
{{ Former::text('email')->label('E-mail')->required(); }}
{{ Former::text('phone')->label('Telefón'); }}


{{ Former::select('format')->label('Formát')->required()->options(array(
    'do formátu A4 :' => array(
        'do A4: samostatná reprodukcia 25 €/ks' => array('value'=>'samostatná reprodukcia (25 €/ks)'), 
        'do A4: reprodukcia s paspartou 35 €/ks' => array('value'=>'reprodukcia s paspartou (35 €/ks)'), 
        'do A4: s paspartou a rámom 40 €/ks' => array('value'=>'s paspartou a rámom (40 €/ks)'), 
        ),
    'od A4 do A3+ :' => array(
        'do A3+: samostatná reprodukcia 35 €/ks' => array('value'=>'samostatná reprodukcia (35 €/ks)'), 
        'do A3+: reprodukcia s paspartou 50 €/ks' => array('value'=>'reprodukcia s paspartou (50 €/ks)'), 
        'do A3+: s paspartou a rámom 60 €/ks' => array('value'=>'s paspartou a rámom (60 €/ks)'), 
        ),  
    'na stiahnutie :' => array(
        'digitálna reprodukcia' => array('value'=>'digitálna reprodukcia')
        ),
)); }}

{{-- ak digitalna --}}
<div id="ucel">
    <div class="alert alert-info col-lg-offset-2 col-md-offset-4" role="alert">
        Autorský zákon nám neumožňuje poskytovať digitálne reprodukcie <abbr title="neprešlo 70 rokov od smrti autora" data-toggle="tooltip">autorsky chránených diel</abbr> na všeobecné súkromné účely (napr. ako dekoráciu). Na základe Vami uvedených informácií vytvorí SNG písomný súhlas s využitím digitálnej reprodukcie iba na predmetný účel &ndash; je to legislatívna ochrana tak pre Vás ako aj pre nás.<br>
        <strong>V prípade záujmu o tlač výtvarných diel môžete využiť objednávku na tlačenú reprodukciu, kde výrobu a úpravu výtlačku zabezpečuje SNG.</strong>
    </div>
{{ Former::select('purpose_kind')->label('Účel')->required()->options(Order::$availablePurposeKinds); }}
{{ Former::textarea('purpose')->label('Účel - podrobnejšie informácie')->required(); }}
</div>
{{-- /ak digitalna --}}

{{-- ak nie digitalna --}}
<div id="miesto_odberu">
{{ Former::select('delivery_point')->label('Miesto osobného odberu')->required()->options(array(
        'Kníhkupectvo Ex Libris v SNG' => array('value'=>'Kníhkupectvo Ex Libris v SNG'), 
        'Zvolenský zámok' => array('value'=>'Zvolenský zámok'), 
)); }}
</div>
{{-- /ak nie digitalna --}}

{{ Former::textarea('note')->label('Poznámka'); }}

{{ Former::actions(Form::submit('Objednať', array('class'=>'btn btn-default btn-outline  uppercase sans')) ) }}

{{Former::close();}}



            </div>
        </div>
    </div>
</section>


@stop

@section('javascript')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
{{ HTML::script('js/jquery.bootstrapvalidator/sk_SK.js') }}

<script type="text/javascript">

    $('#order').bootstrapValidator({
                feedbackIcons: {
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'                    
                },
                live: 'enabled',
                submitButtons: 'input[type="submit"]',
                locale: 'sk_SK',
                excluded: [':disabled', ':hidden', ':not(:visible)']
    })
    .on('change', '#format', function() {
            var isDigital = $(this).val() == 'digitálna reprodukcia';
            $('#order').bootstrapValidator('enableFieldValidators', 'purpose', isDigital);
        });

    function tooglePurpose() {
        if( $('#format').val() == 'digitálna reprodukcia')  {
            $("#ucel").show();
            $("#purpose").attr("disabled", false);
            $("#miesto_odberu").hide();
            $("#delivery_point").attr("disabled", true);
        } else {
            $("#ucel").hide();        
            $("#purpose").attr("disabled", true);
            $("#miesto_odberu").show();
            $("#delivery_point").attr("disabled", false);
        }
    } 

    tooglePurpose();

    $("#format").change(function(){
        tooglePurpose()
    });


</script>
@stop

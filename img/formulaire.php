<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="jquery.signaturepad.css">

    <style type="text/css">

        body { margin-left: 2%; margin-rigt: 5%;
        }

        form {  /* set width in form, not fieldset (still takes up more room w/ fieldset width */
            font:70% verdana,arial,sans-serif;
            margin: 0;
            padding: 0;
            min-width: 500px;
            max-width: 1000px;
            width: 700px;

        }

        form fieldset {
        / * clear: both; note that this clear causes inputs to break to left in ie5.x mac, commented out */
            border-color: #000;
            border-width: 1px;
            border-style: solid;
            padding: 10px;        /* padding in fieldset support spotty in IE */
            margin: 0;
        }

        form fieldset legend {
            font-size:1.1em; /* bump up legend font size, not too large or it'll overwrite border on left */
            /* be careful with padding, it'll shift the nice offset on top of border  */
        }

        form label {
            display: block;  /* block float the labels to left column, set a width */
            float: left;
            width: 300px;
            padding: 0;
            margin: 5px 0 0; /* set top margin same as form input - textarea etc. elements */
            text-align: right;
        }

        form fieldset label:first-letter { /* use first-letter pseudo-class to underline accesskey, note that */
            text-decoration:underline;    /* Firefox 1.07 WIN and Explorer 5.2 Mac don't support first-letter */
            /* pseudo-class on legend elements, but do support it on label elements */
            /* we instead underline first letter on each label element and accesskey */
            /* each input. doing only legends would  lessens cognitive load */
            /* opera breaks after first letter underlined legends but not labels */
        }

        form input, select {
            /* display: inline; inline display must not be set or will hide submit buttons in IE 5x mac */
            width:auto;      /* set width of form elements to auto-size, otherwise watch for wrap on resize */
            margin:5px 0 0 10px; /* set margin on left of form elements rather than right of
                              label aligns textarea better in IE */
        }

        form br {
            clear:left; /* setting clear on inputs didn't work consistently, so brs added for degrade */
        }


        img {
            width: 85px;
        }

    </style>

    <script type='text/javascript'>
        $(window).load(function(){
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function(){
                readURL(this);
            });
        });
        function sf(){document.f.firstname.focus();}
    </script>
</head>
<body onLoad=sf()>


<center><img  src="https://www.lehavreseinemetropole.fr/sites/default/files/LOGO_110x110.png" /></center>
<fieldset>
    <legend>Service Collecte des dechets</legend>
    <p>ABSENCES INJUSTIFIEES DE LA JOURNEE DU <input type="date"/> </p>

</fieldset>

<fieldset>
    <legend>Agent</legend>
    <label for="firstname" accesskey="f">Nom: </label>
    <input type="text" id="firstname" name="firstname" tabindex="1" value="" title="first name"><br>
    <label for="lastname" accesskey="l">Prenom: </label>
    <input type="text" id="lastname" name="lastname" tabindex="2" title="last name"><br>
    <label for="lastname" accesskey="l">Grade: </label>
    <select><option>ADJOINT TECHNIQUE</option><option>AGENT DE MAITRISE</option><option>TECHNICIEN</option><option>INGENIEUR</option></select><br>
    <label for="lastname" accesskey="l"> Fonction: </label>
    <select><option>CHAUFFEUR</option><option>RIPEUR</option><option>LAVEUR</option><option>ENCADRANT</option><option>CHEF DE SECTEUR</option></select><br>			<label for="lastname" accesskey="l">Horaire de travail du jour d'absence: </label>
    <input type="time" id="lastname" name="lastname" tabindex="2" title="last name">		<input type="time" id="lastname" name="lastname" tabindex="2" title="last name"><br><br>

</fieldset>
<fieldset>
    <legend>Informations</legend>
    <fieldset><input type="Checkbox" accesskey="l">	N’a pas prévenu sa hiérarchie dans les délais réglementaires (au plus
        tard 3h30 après l’heure habituelle de prise de fonction) <br><br></fieldset>
    <fieldset>
        <input type="Checkbox" accesskey="l">A prévenu sa hiérarchie Le <input type=date/>  Reçu par :<input type=TEXT/><BR>Heure d'appel :<input type=time/>
        <br>
        <br></fieldset>
    <fieldset>	<input type="Checkbox" accesskey="l"> Doit consulter son médecin dans la journée et informera sa hiérarchie dans les meilleurs délais possibles
        <br>
        <br></fieldset>
    <fieldset>	<input type="Checkbox" accesskey="l">	A consulté son médecin qui lui a prescrit un arrêt de travail du <input type=date/>  au :<input type=date/>
        et adressera son certificat médical sous 48 heures à sa hiérarchie<br>
        <br>
        <input type="Checkbox" accesskey="l">Est hospitalisé et adressera dès que possible un certificat de
        présence
        <br></fieldset>
    <fieldset>	<input type="Checkbox" accesskey="l"> Autres situations (enfants malades...) : 			 <input type="texte" name="blablabla" style="width:350px;height: 30px;"/> <br>
    </fieldset>
    <table>
        <tr>
            <td>
                Nom du responsable de secteur : 		<input type="text" id="lastname" name="lastname" tabindex="2" title="last name"><br>
                Date :  <input type="date"/>
                <head>

                    <style>
                        body { font: normal 100.01%/1.375 "Helvetica Neue",Helvetica,Arial,sans-serif; }

                        .sigPad {
                            margin: 0;
                            padding: 0;
                            width: 200px;
                        }

                        .sigPad label {
                            display: block;
                            margin: 0 0 0.515em;
                            padding: 0;

                            color: #000;
                            font: italic normal 1em/1.375 Georgia,Times,serif;
                        }

                        .sigPad label.error {
                            color: #f33;
                        }

                        .sigPad input {
                            margin: 0;
                            padding: 0.2em 0;
                            width: 198px;

                            border: 1px solid #666;

                            font-size: 1em;
                        }

                        .sigPad input.error {
                            border-color: #f33;
                        }

                        .sigPad button {
                            margin: 1em 0 0 0;
                            padding: 0.6em 0.6em 0.7em;

                            background-color: #ccc;
                            border: 0;
                            -moz-border-radius: 8px;
                            -webkit-border-radius: 8px;
                            border-radius: 8px;

                            cursor: pointer;

                            color: #555;
                            font: bold 1em/1.375 sans-serif;
                            text-align: left;
                        }

                        .sigPad button:hover {
                            background-color: #333;

                            color: #fff;
                        }

                        .sig {
                            display: none;
                        }

                        .sigNav {
                            display: none;
                            height: 2.25em;
                            margin: 0;
                            padding: 0;
                            position: relative;

                            list-style-type: none;
                        }

                        .sigNav li {
                            display: inline;
                            float: left;
                            margin: 0;
                            padding: 0;
                        }

                        .sigNav a,
                        .sigNav a:link,
                        .sigNav a:visited {
                            display: block;
                            margin: 0;
                            padding: 0 0.6em;

                            border: 0;

                            color: #333;
                            font-weight: bold;
                            line-height: 2.25em;
                            text-decoration: underline;
                        }

                        .sigNav a.current,
                        .sigNav a.current:link,
                        .sigNav a.current:visited {
                            background-color: #666;
                            -moz-border-radius-topleft: 8px;
                            -moz-border-radius-topright: 8px;
                            -webkit-border-top-left-radius: 8px;
                            -webkit-border-top-right-radius: 8px;
                            border-radius: 8px 8px 0 0;

                            color: #fff;
                            text-decoration: none;
                        }

                        .sigNav .typeIt a.current,
                        .sigNav .typeIt a.current:link,
                        .sigNav .typeIt a.current:visited {
                            background-color: #ccc;

                            color: #555;
                        }

                        .sigNav .clearButton {
                            bottom: 0.2em;
                            display: none;
                            position: absolute;
                            right: 0;

                            font-size: 0.75em;
                            line-height: 1.375;
                        }

                        .sigWrapper {
                            clear: both;
                            height: 55px;

                            border: 1px solid #ccc;
                        }

                        .sigWrapper.current {
                            border-color: #666;
                        }

                        .signed .sigWrapper {
                            border: 0;
                        }

                        .pad {
                            position: relative;


                            /**
                             * For cross browser compatibility, this should be an absolute URL
                             * In IE the cursor is relative to the HTML document
                             * In all other browsers the cursor is relative to the CSS file
                             *
                             * http://www.useragentman.com/blog/2011/12/21/cross-browser-css-cursor-images-in-depth/
                             */
                            cursor: url("../assets/pen.cur"), crosshair;
                            /**
                             * IE will ignore this line because of the hotspot position
                             * Unfortunately we need this twice, because some browsers ignore the hotspot inside the .cur
                             */
                            cursor: url("pen.cur") 16 16, crosshair;

                            -ms-touch-action: none;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            -o-user-select: none;
                            user-select: none;
                        }

                        .typed {
                            height: 55px;
                            margin: 0;
                            padding: 0 5px;
                            position: absolute;
                            z-index: 90;

                            cursor: default;

                            color: black;
                            font: normal 1.875em/50px "Journal",Georgia,Times,serif;
                        }

                        .typeItDesc,
                        .drawItDesc {
                            display: none;
                            margin: 0.75em 0 0.515em;
                            padding: 0.515em 0 0;

                            border-top: 3px solid #ccc;

                            color: #000;
                            font: italic normal 1em/1.375 Georgia,Times,serif;
                        }

                        p.error {
                            display: block;
                            margin: 0.5em 0;
                            padding: 0.4em;

                            background-color: #f33;

                            color: #fff;
                            font-weight: bold;
                        }

                        table {

                            width: 100%;
                        }

                        td {

                            width: 50%;
                        }
                    </style>

                    <!--[if lt IE 9]><script src="../assets/flashcanvas.js"></script><![endif]-->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>


            </td><td>
                <form method="post" action="" class="sigPad" style="float: right;">




                    <div class="typed" style="float: right; "></div>
                    <canvas class="pad" width="250" height="60" style="float: right; "></canvas>
                    <input type="hidden" name="output" class="output" style="float: right; ">

                    <ul class="sigNav" style="float: right; ">
                        <p> SIGNATURE </p>


                    </ul>

                </form>

            </td>
        </tr>
    </table>

    <script>
        $(document).ready(function() {
            $('.sigPad').signaturePad({drawOnly:true});
        });
    </script>



    <script>if(!this.JSON){this.JSON={};}
        (function(){function f(n){return n<10?'0'+n:n;}
            if(typeof Date.prototype.toJSON!=='function'){Date.prototype.toJSON=function(key){return isFinite(this.valueOf())?this.getUTCFullYear()+'-'+
                f(this.getUTCMonth()+1)+'-'+
                f(this.getUTCDate())+'T'+
                f(this.getUTCHours())+':'+
                f(this.getUTCMinutes())+':'+
                f(this.getUTCSeconds())+'Z':null;};String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(key){return this.valueOf();};}
            var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={'\b':'\\b','\t':'\\t','\n':'\\n','\f':'\\f','\r':'\\r','"':'\\"','\\':'\\\\'},rep;function quote(string){escapable.lastIndex=0;return escapable.test(string)?'"'+string.replace(escapable,function(a){var c=meta[a];return typeof c==='string'?c:'\\u'+('0000'+a.charCodeAt(0).toString(16)).slice(-4);})+'"':'"'+string+'"';}
            function str(key,holder){var i,k,v,length,mind=gap,partial,value=holder[key];if(value&&typeof value==='object'&&typeof value.toJSON==='function'){value=value.toJSON(key);}
                if(typeof rep==='function'){value=rep.call(holder,key,value);}
                switch(typeof value){case'string':return quote(value);case'number':return isFinite(value)?String(value):'null';case'boolean':case'null':return String(value);case'object':if(!value){return'null';}
                    gap+=indent;partial=[];if(Object.prototype.toString.apply(value)==='[object Array]'){length=value.length;for(i=0;i<length;i+=1){partial[i]=str(i,value)||'null';}
                        v=partial.length===0?'[]':gap?'[\n'+gap+
                            partial.join(',\n'+gap)+'\n'+
                            mind+']':'['+partial.join(',')+']';gap=mind;return v;}
                    if(rep&&typeof rep==='object'){length=rep.length;for(i=0;i<length;i+=1){k=rep[i];if(typeof k==='string'){v=str(k,value);if(v){partial.push(quote(k)+(gap?': ':':')+v);}}}}else{for(k in value){if(Object.hasOwnProperty.call(value,k)){v=str(k,value);if(v){partial.push(quote(k)+(gap?': ':':')+v);}}}}
                    v=partial.length===0?'{}':gap?'{\n'+gap+partial.join(',\n'+gap)+'\n'+
                        mind+'}':'{'+partial.join(',')+'}';gap=mind;return v;}}
            if(typeof JSON.stringify!=='function'){JSON.stringify=function(value,replacer,space){var i;gap='';indent='';if(typeof space==='number'){for(i=0;i<space;i+=1){indent+=' ';}}else if(typeof space==='string'){indent=space;}
                rep=replacer;if(replacer&&typeof replacer!=='function'&&(typeof replacer!=='object'||typeof replacer.length!=='number')){throw new Error('JSON.stringify');}
                return str('',{'':value});};}
            if(typeof JSON.parse!=='function'){JSON.parse=function(text,reviver){var j;function walk(holder,key){var k,v,value=holder[key];if(value&&typeof value==='object'){for(k in value){if(Object.hasOwnProperty.call(value,k)){v=walk(value,k);if(v!==undefined){value[k]=v;}else{delete value[k];}}}}
                return reviver.call(holder,key,value);}
                cx.lastIndex=0;if(cx.test(text)){text=text.replace(cx,function(a){return'\\u'+
                    ('0000'+a.charCodeAt(0).toString(16)).slice(-4);});}
                if(/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,'@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,']').replace(/(?:^|:|,)(?:\s*\[)+/g,''))){j=eval('('+text+')');return typeof reviver==='function'?walk({'':j},''):j;}
                throw new SyntaxError('JSON.parse');};}}());</script>

    <script>
        /**!
         * SignaturePad: A jQuery plugin for assisting in the creation of an HTML5 canvas based signature pad. Records the drawn signature in JSON for later regeneration.
         * @project signature-pad
         * @author Thomas J Bradley <hey@thomasjbradley.ca>
         * @link https://github.com/thomasjbradley/signature-pad
         * @link https://github.com/thomasjbradley/signature-pad
         * @copyright 2016 Thomas J Bradley
         * @license BSD-3-CLAUSE
         * @version 2.5.2
         */
        !function($){function SignaturePad(selector,options){function clearMouseLeaveTimeout(){clearTimeout(mouseLeaveTimeout),mouseLeaveTimeout=!1,mouseButtonDown=!1}function drawLine(e,newYOffset){var offset,newX,newY;return e.preventDefault(),offset=$(e.target).offset(),clearTimeout(mouseLeaveTimeout),mouseLeaveTimeout=!1,"undefined"!=typeof e.targetTouches?(newX=Math.floor(e.targetTouches[0].pageX-offset.left),newY=Math.floor(e.targetTouches[0].pageY-offset.top)):(newX=Math.floor(e.pageX-offset.left),newY=Math.floor(e.pageY-offset.top)),previous.x===newX&&previous.y===newY?!0:(null===previous.x&&(previous.x=newX),null===previous.y&&(previous.y=newY),newYOffset&&(newY+=newYOffset),canvasContext.beginPath(),canvasContext.moveTo(previous.x,previous.y),canvasContext.lineTo(newX,newY),canvasContext.lineCap=settings.penCap,canvasContext.stroke(),canvasContext.closePath(),output.push({lx:newX,ly:newY,mx:previous.x,my:previous.y}),previous.x=newX,previous.y=newY,void(settings.onDraw&&"function"==typeof settings.onDraw&&settings.onDraw.apply(self)))}function stopDrawingWrapper(){stopDrawing()}function stopDrawing(e){e?drawLine(e,1):(touchable?canvas.each(function(){this.removeEventListener("touchmove",drawLine)}):canvas.unbind("mousemove.signaturepad"),output.length>0&&settings.onDrawEnd&&"function"==typeof settings.onDrawEnd&&settings.onDrawEnd.apply(self)),previous.x=null,previous.y=null,settings.output&&output.length>0&&$(settings.output,context).val(JSON.stringify(output))}function drawSigLine(){return settings.lineWidth?(canvasContext.beginPath(),canvasContext.lineWidth=settings.lineWidth,canvasContext.strokeStyle=settings.lineColour,canvasContext.moveTo(settings.lineMargin,settings.lineTop),canvasContext.lineTo(element.width-settings.lineMargin,settings.lineTop),canvasContext.stroke(),void canvasContext.closePath()):!1}function clearCanvas(){canvasContext.clearRect(0,0,element.width,element.height),canvasContext.fillStyle=settings.bgColour,canvasContext.fillRect(0,0,element.width,element.height),settings.displayOnly||drawSigLine(),canvasContext.lineWidth=settings.penWidth,canvasContext.strokeStyle=settings.penColour,$(settings.output,context).val(""),output=[],stopDrawing()}function onMouseMove(e,o){null==previous.x?drawLine(e,1):drawLine(e,o)}function startDrawing(e,touchObject){touchable?touchObject.addEventListener("touchmove",onMouseMove,!1):canvas.bind("mousemove.signaturepad",onMouseMove),drawLine(e,1)}function disableCanvas(){eventsBound=!1,canvas.each(function(){this.removeEventListener&&(this.removeEventListener("touchend",stopDrawingWrapper),this.removeEventListener("touchcancel",stopDrawingWrapper),this.removeEventListener("touchmove",drawLine)),this.ontouchstart&&(this.ontouchstart=null)}),$(document).unbind("mouseup.signaturepad"),canvas.unbind("mousedown.signaturepad"),canvas.unbind("mousemove.signaturepad"),canvas.unbind("mouseleave.signaturepad"),$(settings.clear,context).unbind("click.signaturepad")}function initDrawEvents(e){return eventsBound?!1:(eventsBound=!0,$("input").blur(),"undefined"!=typeof e.targetTouches&&(touchable=!0),void(touchable?(canvas.each(function(){this.addEventListener("touchend",stopDrawingWrapper,!1),this.addEventListener("touchcancel",stopDrawingWrapper,!1)}),canvas.unbind("mousedown.signaturepad")):($(document).bind("mouseup.signaturepad",function(){mouseButtonDown&&(stopDrawing(),clearMouseLeaveTimeout())}),canvas.bind("mouseleave.signaturepad",function(e){mouseButtonDown&&stopDrawing(e),mouseButtonDown&&!mouseLeaveTimeout&&(mouseLeaveTimeout=setTimeout(function(){stopDrawing(),clearMouseLeaveTimeout()},500))}),canvas.each(function(){this.ontouchstart=null}))))}function drawIt(){$(settings.typed,context).hide(),clearCanvas(),canvas.each(function(){this.ontouchstart=function(e){e.preventDefault(),mouseButtonDown=!0,initDrawEvents(e),startDrawing(e,this)}}),canvas.bind("mousedown.signaturepad",function(e){return e.preventDefault(),e.which>1?!1:(mouseButtonDown=!0,initDrawEvents(e),void startDrawing(e))}),$(settings.clear,context).bind("click.signaturepad",function(e){e.preventDefault(),clearCanvas()}),$(settings.typeIt,context).bind("click.signaturepad",function(e){e.preventDefault(),typeIt()}),$(settings.drawIt,context).unbind("click.signaturepad"),$(settings.drawIt,context).bind("click.signaturepad",function(e){e.preventDefault()}),$(settings.typeIt,context).removeClass(settings.currentClass),$(settings.drawIt,context).addClass(settings.currentClass),$(settings.sig,context).addClass(settings.currentClass),$(settings.typeItDesc,context).hide(),$(settings.drawItDesc,context).show(),$(settings.clear,context).show()}function typeIt(){clearCanvas(),disableCanvas(),$(settings.typed,context).show(),$(settings.drawIt,context).bind("click.signaturepad",function(e){e.preventDefault(),drawIt()}),$(settings.typeIt,context).unbind("click.signaturepad"),$(settings.typeIt,context).bind("click.signaturepad",function(e){e.preventDefault()}),$(settings.output,context).val(""),$(settings.drawIt,context).removeClass(settings.currentClass),$(settings.typeIt,context).addClass(settings.currentClass),$(settings.sig,context).removeClass(settings.currentClass),$(settings.drawItDesc,context).hide(),$(settings.clear,context).hide(),$(settings.typeItDesc,context).show(),typeItCurrentFontSize=typeItDefaultFontSize=$(settings.typed,context).css("font-size").replace(/px/,"")}function type(val){var typed=$(settings.typed,context),cleanedVal=$.trim(val.replace(/>/g,"&gt;").replace(/</g,"&lt;")),oldLength=typeItNumChars,edgeOffset=.5*typeItCurrentFontSize;if(typeItNumChars=cleanedVal.length,typed.html(cleanedVal),!cleanedVal)return void typed.css("font-size",typeItDefaultFontSize+"px");if(typeItNumChars>oldLength&&typed.outerWidth()>element.width)for(;typed.outerWidth()>element.width;)typeItCurrentFontSize--,typed.css("font-size",typeItCurrentFontSize+"px");if(oldLength>typeItNumChars&&typed.outerWidth()+edgeOffset<element.width&&typeItDefaultFontSize>typeItCurrentFontSize)for(;typed.outerWidth()+edgeOffset<element.width&&typeItDefaultFontSize>typeItCurrentFontSize;)typeItCurrentFontSize++,typed.css("font-size",typeItCurrentFontSize+"px")}function onBeforeValidate(context,settings){$("p."+settings.errorClass,context).remove(),context.removeClass(settings.errorClass),$("input, label",context).removeClass(settings.errorClass)}function onFormError(errors,context,settings){errors.nameInvalid&&(context.prepend(['<p class="',settings.errorClass,'">',settings.errorMessage,"</p>"].join("")),$(settings.name,context).focus(),$(settings.name,context).addClass(settings.errorClass),$("label[for="+$(settings.name).attr("id")+"]",context).addClass(settings.errorClass)),errors.drawInvalid&&context.prepend(['<p class="',settings.errorClass,'">',settings.errorMessageDraw,"</p>"].join(""))}function validateForm(){var valid=!0,errors={drawInvalid:!1,nameInvalid:!1},onBeforeArguments=[context,settings],onErrorArguments=[errors,context,settings];return settings.onBeforeValidate&&"function"==typeof settings.onBeforeValidate?settings.onBeforeValidate.apply(self,onBeforeArguments):onBeforeValidate.apply(self,onBeforeArguments),settings.drawOnly&&output.length<1&&(errors.drawInvalid=!0,valid=!1),""===$(settings.name,context).val()&&(errors.nameInvalid=!0,valid=!1),settings.onFormError&&"function"==typeof settings.onFormError?settings.onFormError.apply(self,onErrorArguments):onFormError.apply(self,onErrorArguments),valid}function drawSignature(paths,context,saveOutput){for(var i in paths)"object"==typeof paths[i]&&(context.beginPath(),context.moveTo(paths[i].mx,paths[i].my),context.lineTo(paths[i].lx,paths[i].ly),context.lineCap=settings.penCap,context.stroke(),context.closePath(),saveOutput&&paths[i].lx&&output.push({lx:paths[i].lx,ly:paths[i].ly,mx:paths[i].mx,my:paths[i].my}))}function init(){parseFloat((/CPU.+OS ([0-9_]{3}).*AppleWebkit.*Mobile/i.exec(navigator.userAgent)||[0,"4_2"])[1].replace("_","."))<4.1&&($.fn.Oldoffset=$.fn.offset,$.fn.offset=function(){var result=$(this).Oldoffset();return result.top-=window.scrollY,result.left-=window.scrollX,result}),$(settings.typed,context).bind("selectstart.signaturepad",function(e){return $(e.target).is(":input")}),canvas.bind("selectstart.signaturepad",function(e){return $(e.target).is(":input")}),!element.getContext&&FlashCanvas&&FlashCanvas.initElement(element),element.getContext&&(canvasContext=element.getContext("2d"),$(settings.sig,context).show(),settings.displayOnly||(settings.drawOnly||($(settings.name,context).bind("keyup.signaturepad",function(){type($(this).val())}),$(settings.name,context).bind("blur.signaturepad",function(){type($(this).val())}),$(settings.drawIt,context).bind("click.signaturepad",function(e){e.preventDefault(),drawIt()})),settings.drawOnly||"drawIt"===settings.defaultAction?drawIt():typeIt(),settings.validateFields&&($(selector).is("form")?$(selector).bind("submit.signaturepad",function(){return validateForm()}):$(selector).parents("form").bind("submit.signaturepad",function(){return validateForm()})),$(settings.sigNav,context).show()))}var self=this,settings=$.extend({},$.fn.signaturePad.defaults,options),context=$(selector),canvas=$(settings.canvas,context),element=canvas.get(0),canvasContext=null,previous={x:null,y:null},output=[],mouseLeaveTimeout=!1,mouseButtonDown=!1,touchable=!1,eventsBound=!1,typeItDefaultFontSize=30,typeItCurrentFontSize=typeItDefaultFontSize,typeItNumChars=0;$.extend(self,{signaturePad:"2.5.2",init:function(){init()},updateOptions:function(options){$.extend(settings,options)},regenerate:function(paths){self.clearCanvas(),$(settings.typed,context).hide(),"string"==typeof paths&&(paths=JSON.parse(paths)),drawSignature(paths,canvasContext,!0),settings.output&&$(settings.output,context).length>0&&$(settings.output,context).val(JSON.stringify(output))},clearCanvas:function(){clearCanvas()},getSignature:function(){return output},getSignatureString:function(){return JSON.stringify(output)},getSignatureImage:function(){var tmpCanvas=document.createElement("canvas"),tmpContext=null,data=null;return tmpCanvas.style.position="absolute",tmpCanvas.style.top="-999em",tmpCanvas.width=element.width,tmpCanvas.height=element.height,document.body.appendChild(tmpCanvas),!tmpCanvas.getContext&&FlashCanvas&&FlashCanvas.initElement(tmpCanvas),tmpContext=tmpCanvas.getContext("2d"),tmpContext.fillStyle=settings.bgColour,tmpContext.fillRect(0,0,element.width,element.height),tmpContext.lineWidth=settings.penWidth,tmpContext.strokeStyle=settings.penColour,drawSignature(output,tmpContext),data=tmpCanvas.toDataURL.apply(tmpCanvas,arguments),document.body.removeChild(tmpCanvas),tmpCanvas=null,data},validateForm:function(){return validateForm()}})}$.fn.signaturePad=function(options){var api=null;return this.each(function(){$.data(this,"plugin-signaturePad")?(api=$.data(this,"plugin-signaturePad"),api.updateOptions(options)):(api=new SignaturePad(this,options),api.init(),$.data(this,"plugin-signaturePad",api))}),api},$.fn.signaturePad.defaults={defaultAction:"typeIt",displayOnly:!1,drawOnly:!1,canvas:"canvas",sig:".sig",sigNav:".sigNav",bgColour:"#000000",penColour:"#145394",penWidth:2,penCap:"round",lineColour:"#ccc",lineWidth:2,lineMargin:5,lineTop:35,name:".name",typed:".typed",clear:".clearButton",typeIt:".typeIt a",drawIt:".drawIt a",typeItDesc:".typeItDesc",drawItDesc:".drawItDesc",output:".output",currentClass:"current",validateFields:!0,errorClass:"error",errorMessage:"Please enter your name",errorMessageDraw:"Please sign the document",onBeforeValidate:null,onFormError:null,onDraw:null,onDrawEnd:null}}(jQuery);


    </script>
    <script>
        /**
         * Usage for accepting signatures:
         *  $('.sigPad').signaturePad()
         *
         * Usage for displaying previous signatures:
         *  $('.sigPad').signaturePad({displayOnly:true}).regenerate(sig)
         *  or
         *  var api = $('.sigPad').signaturePad({displayOnly:true})
         *  api.regenerate(sig)
         */
        (function ($) {

            function SignaturePad (selector, options) {
                /**
                 * Reference to the object for use in public methods
                 *
                 * @private
                 *
                 * @type {Object}
                 */
                var self = this

                    /**
                     * Holds the merged default settings and user passed settings
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , settings = $.extend({}, $.fn.signaturePad.defaults, options)

                    /**
                     * The current context, as passed by jQuery, of selected items
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , context = $(selector)

                    /**
                     * jQuery reference to the canvas element inside the signature pad
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , canvas = $(settings.canvas, context)

                    /**
                     * Dom reference to the canvas element inside the signature pad
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , element = canvas.get(0)

                    /**
                     * The drawing context for the signature canvas
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , canvasContext = null

                    /**
                     * Holds the previous point of drawing
                     * Disallows drawing over the same location to make lines more delicate
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , previous = {'x': null, 'y': null}

                    /**
                     * An array holding all the points and lines to generate the signature
                     * Each item is an object like:
                     * {
                     *   mx: moveTo x coordinate
                     *   my: moveTo y coordinate
                     *   lx: lineTo x coordinate
                     *   lx: lineTo y coordinate
                     * }
                     *
                     * @private
                     *
                     * @type {Array}
                     */
                    , output = []

                    /**
                     * Stores a timeout for when the mouse leaves the canvas
                     * If the mouse has left the canvas for a specific amount of time
                     * Stops drawing on the canvas
                     *
                     * @private
                     *
                     * @type {Object}
                     */
                    , mouseLeaveTimeout = false

                    /**
                     * Whether the mouse button is currently pressed down or not
                     *
                     * @private
                     *
                     * @type {Boolean}
                     */
                    , mouseButtonDown = false

                    /**
                     * Whether the browser is a touch event browser or not
                     *
                     * @private
                     *
                     * @type {Boolean}
                     */
                    , touchable = false

                    /**
                     * Whether events have already been bound to the canvas or not
                     *
                     * @private
                     *
                     * @type {Boolean}
                     */
                    , eventsBound = false

                    /**
                     * Remembers the default font-size when typing, and will allow it to be scaled for bigger/smaller names
                     *
                     * @private
                     *
                     * @type {Number}
                     */
                    , typeItDefaultFontSize = 30

                    /**
                     * Remembers the current font-size when typing
                     *
                     * @private
                     *
                     * @type {Number}
                     */
                    , typeItCurrentFontSize = typeItDefaultFontSize

                    /**
                     * Remembers how many characters are in the name field, to help with the scaling feature
                     *
                     * @private
                     *
                     * @type {Number}
                     */
                    , typeItNumChars = 0


                /**
                 * Clears the mouseLeaveTimeout
                 * Resets some other variables that may be active
                 *
                 * @private
                 */
                function clearMouseLeaveTimeout () {
                    clearTimeout(mouseLeaveTimeout)
                    mouseLeaveTimeout = false
                    mouseButtonDown = false
                }

                /**
                 * Draws a line on canvas using the mouse position
                 * Checks previous position to not draw over top of previous drawing
                 *  (makes the line really thick and poorly anti-aliased)
                 *
                 * @private
                 *
                 * @param {Object} e The event object
                 * @param {Number} newYOffset A pixel value for drawing the newY, used for drawing a single dot on click
                 */
                function drawLine (e, newYOffset) {
                    var offset, newX, newY

                    e.preventDefault()

                    offset = $(e.target).offset()

                    clearTimeout(mouseLeaveTimeout)
                    mouseLeaveTimeout = false

                    if (typeof e.targetTouches !== 'undefined') {
                        newX = Math.floor(e.targetTouches[0].pageX - offset.left)
                        newY = Math.floor(e.targetTouches[0].pageY - offset.top)
                    } else {
                        newX = Math.floor(e.pageX - offset.left)
                        newY = Math.floor(e.pageY - offset.top)
                    }

                    if (previous.x === newX && previous.y === newY)
                        return true

                    if (previous.x === null)
                        previous.x = newX

                    if (previous.y === null)
                        previous.y = newY

                    if (newYOffset)
                        newY += newYOffset

                    canvasContext.beginPath()
                    canvasContext.moveTo(previous.x, previous.y)
                    canvasContext.lineTo(newX, newY)
                    canvasContext.lineCap = settings.penCap
                    canvasContext.stroke()
                    canvasContext.closePath()

                    output.push({
                        'lx' : newX
                        , 'ly' : newY
                        , 'mx' : previous.x
                        , 'my' : previous.y
                    })

                    previous.x = newX
                    previous.y = newY

                    if (settings.onDraw && typeof settings.onDraw === 'function')
                        settings.onDraw.apply(self)
                }

                /**
                 * Callback wrapper for executing stopDrawing without the event
                 * Put up here so that it can be removed at a later time
                 *
                 * @private
                 */
                function stopDrawingWrapper () {
                    stopDrawing()
                }

                /**
                 * Callback registered to mouse/touch events of the canvas
                 * Stops the drawing abilities
                 *
                 * @private
                 *
                 * @param {Object} e The event object
                 */
                function stopDrawing (e) {
                    if (!!e) {
                        drawLine(e, 1)
                    } else {
                        if (touchable) {
                            canvas.each(function () {
                                this.removeEventListener('touchmove', drawLine)
                                // this.removeEventListener('MSPointerMove', drawLine)
                            })
                        } else {
                            canvas.unbind('mousemove.signaturepad')
                        }

                        if (output.length > 0 && settings.onDrawEnd && typeof settings.onDrawEnd === 'function')
                            settings.onDrawEnd.apply(self)
                    }

                    previous.x = null
                    previous.y = null

                    if (settings.output && output.length > 0)
                        $(settings.output, context).val(JSON.stringify(output))
                }

                /**
                 * Draws the signature line
                 *
                 * @private
                 */
                function drawSigLine () {
                    if (!settings.lineWidth)
                        return false

                    canvasContext.beginPath()
                    canvasContext.lineWidth = settings.lineWidth
                    canvasContext.strokeStyle = settings.lineColour
                    canvasContext.moveTo(settings.lineMargin, settings.lineTop)
                    canvasContext.lineTo(element.width - settings.lineMargin, settings.lineTop)
                    canvasContext.stroke()
                    canvasContext.closePath()
                }

                /**
                 * Clears all drawings off the canvas and redraws the signature line
                 *
                 * @private
                 */
                function clearCanvas () {
                    canvasContext.clearRect(0, 0, element.width, element.height)
                    canvasContext.fillStyle = settings.bgColour
                    canvasContext.fillRect(0, 0, element.width, element.height)

                    if (!settings.displayOnly)
                        drawSigLine()

                    canvasContext.lineWidth = settings.penWidth
                    canvasContext.strokeStyle = settings.penColour

                    $(settings.output, context).val('')
                    output = []

                    stopDrawing()
                }

                /**
                 * Callback registered to mouse/touch events of the canvas
                 * Draws a line at the mouse cursor location, starting a new line if necessary
                 *
                 * @private
                 *
                 * @param {Object} e The event object
                 * @param {Object} o The object context registered to the event; canvas
                 */
                function onMouseMove(e, o) {
                    if (previous.x == null) {
                        drawLine(e, 1)
                    } else {
                        drawLine(e, o)
                    }
                }

                /**
                 * Callback registered to mouse/touch events of canvas
                 * Triggers the drawLine function
                 *
                 * @private
                 *
                 * @param {Object} e The event object
                 * @param {Object} touchObject The object context registered to the event; canvas
                 */
                function startDrawing (e, touchObject) {
                    if (touchable) {
                        touchObject.addEventListener('touchmove', onMouseMove, false)
                        // touchObject.addEventListener('MSPointerMove', onMouseMove, false)
                    } else {
                        canvas.bind('mousemove.signaturepad', onMouseMove)
                    }

                    // Draws a single point on initial mouse down, for people with periods in their name
                    drawLine(e, 1)
                }

                /**
                 * Removes all the mouse events from the canvas
                 *
                 * @private
                 */
                function disableCanvas () {
                    eventsBound = false

                    canvas.each(function () {
                        if (this.removeEventListener) {
                            this.removeEventListener('touchend', stopDrawingWrapper)
                            this.removeEventListener('touchcancel', stopDrawingWrapper)
                            this.removeEventListener('touchmove', drawLine)
                            // this.removeEventListener('MSPointerUp', stopDrawingWrapper)
                            // this.removeEventListener('MSPointerCancel', stopDrawingWrapper)
                            // this.removeEventListener('MSPointerMove', drawLine)
                        }

                        if (this.ontouchstart)
                            this.ontouchstart = null;
                    })

                    $(document).unbind('mouseup.signaturepad')
                    canvas.unbind('mousedown.signaturepad')
                    canvas.unbind('mousemove.signaturepad')
                    canvas.unbind('mouseleave.signaturepad')

                    $(settings.clear, context).unbind('click.signaturepad')
                }

                /**
                 * Lazy touch event detection
                 * Uses the first press on the canvas to detect either touch or mouse reliably
                 * Will then bind other events as needed
                 *
                 * @private
                 *
                 * @param {Object} e The event object
                 */
                function initDrawEvents (e) {
                    if (eventsBound)
                        return false

                    eventsBound = true

                    // Closes open keyboards to free up space
                    $('input').blur();

                    if (typeof e.targetTouches !== 'undefined')
                        touchable = true

                    if (touchable) {
                        canvas.each(function () {
                            this.addEventListener('touchend', stopDrawingWrapper, false)
                            this.addEventListener('touchcancel', stopDrawingWrapper, false)
                            // this.addEventListener('MSPointerUp', stopDrawingWrapper, false)
                            // this.addEventListener('MSPointerCancel', stopDrawingWrapper, false)
                        })

                        canvas.unbind('mousedown.signaturepad')
                    } else {
                        $(document).bind('mouseup.signaturepad', function () {
                            if (mouseButtonDown) {
                                stopDrawing()
                                clearMouseLeaveTimeout()
                            }
                        })
                        canvas.bind('mouseleave.signaturepad', function (e) {
                            if (mouseButtonDown) stopDrawing(e)

                            if (mouseButtonDown && !mouseLeaveTimeout) {
                                mouseLeaveTimeout = setTimeout(function () {
                                    stopDrawing()
                                    clearMouseLeaveTimeout()
                                }, 500)
                            }
                        })

                        canvas.each(function () {
                            this.ontouchstart = null
                        })
                    }
                }

                /**
                 * Triggers the abilities to draw on the canvas
                 * Sets up mouse/touch events, hides and shows descriptions and sets current classes
                 *
                 * @private
                 */
                function drawIt () {
                    $(settings.typed, context).hide()
                    clearCanvas()

                    canvas.each(function () {
                        this.addEventListener('touchstart', function(e) {
                            e.preventDefault()
                            mouseButtonDown = true
                            initDrawEvents(e)
                            startDrawing(e, this)
                        })
                    })

                    canvas.bind('mousedown.signaturepad', function (e) {
                        e.preventDefault()

                        // Only allow left mouse clicks to trigger signature drawing
                        if (e.which > 1) return false

                        mouseButtonDown = true
                        initDrawEvents(e)
                        startDrawing(e)
                    })

                    $(settings.clear, context).bind('click.signaturepad', function (e) { e.preventDefault(); clearCanvas() })

                    $(settings.typeIt, context).bind('click.signaturepad', function (e) { e.preventDefault(); typeIt() })
                    $(settings.drawIt, context).unbind('click.signaturepad')
                    $(settings.drawIt, context).bind('click.signaturepad', function (e) { e.preventDefault() })

                    $(settings.typeIt, context).removeClass(settings.currentClass)
                    $(settings.drawIt, context).addClass(settings.currentClass)
                    $(settings.sig, context).addClass(settings.currentClass)

                    $(settings.typeItDesc, context).hide()
                    $(settings.drawItDesc, context).show()
                    $(settings.clear, context).show()
                }

                /**
                 * Triggers the abilities to type in the input for generating a signature
                 * Sets up mouse events, hides and shows descriptions and sets current classes
                 *
                 * @private
                 */
                function typeIt () {
                    clearCanvas()
                    disableCanvas()
                    $(settings.typed, context).show()

                    $(settings.drawIt, context).bind('click.signaturepad', function (e) { e.preventDefault(); drawIt() })
                    $(settings.typeIt, context).unbind('click.signaturepad')
                    $(settings.typeIt, context).bind('click.signaturepad', function (e) { e.preventDefault() })

                    $(settings.output, context).val('')

                    $(settings.drawIt, context).removeClass(settings.currentClass)
                    $(settings.typeIt, context).addClass(settings.currentClass)
                    $(settings.sig, context).removeClass(settings.currentClass)

                    $(settings.drawItDesc, context).hide()
                    $(settings.clear, context).hide()
                    $(settings.typeItDesc, context).show()

                    typeItCurrentFontSize = typeItDefaultFontSize = $(settings.typed, context).css('font-size').replace(/px/, '')
                }

                /**
                 * Callback registered on key up and blur events for input field
                 * Writes the text fields value as Html into an element
                 *
                 * @private
                 *
                 * @param {String} val The value of the input field
                 */
                function type (val) {
                    var typed = $(settings.typed, context)
                        , cleanedVal = $.trim(val.replace(/>/g, '&gt;').replace(/</g, '&lt;'))
                        , oldLength = typeItNumChars
                        , edgeOffset = typeItCurrentFontSize * 0.5

                    typeItNumChars = cleanedVal.length
                    typed.html(cleanedVal)

                    if (!cleanedVal) {
                        typed.css('font-size', typeItDefaultFontSize + 'px')
                        return
                    }

                    if (typeItNumChars > oldLength && typed.outerWidth() > element.width) {
                        while (typed.outerWidth() > element.width) {
                            typeItCurrentFontSize--
                            typed.css('font-size', typeItCurrentFontSize + 'px')
                        }
                    }

                    if (typeItNumChars < oldLength && typed.outerWidth() + edgeOffset < element.width && typeItCurrentFontSize < typeItDefaultFontSize) {
                        while (typed.outerWidth() + edgeOffset < element.width && typeItCurrentFontSize < typeItDefaultFontSize) {
                            typeItCurrentFontSize++
                            typed.css('font-size', typeItCurrentFontSize + 'px')
                        }
                    }
                }

                /**
                 * Default onBeforeValidate function to clear errors
                 *
                 * @private
                 *
                 * @param {Object} context current context object
                 * @param {Object} settings provided settings
                 */
                function onBeforeValidate (context, settings) {
                    $('p.' + settings.errorClass, context).remove()
                    context.removeClass(settings.errorClass)
                    $('input, label', context).removeClass(settings.errorClass)
                }

                /**
                 * Default onFormError function to show errors
                 *
                 * @private
                 *
                 * @param {Object} errors object contains validation errors (e.g. nameInvalid=true)
                 * @param {Object} context current context object
                 * @param {Object} settings provided settings
                 */
                function onFormError (errors, context, settings) {
                    if (errors.nameInvalid) {
                        context.prepend(['<p class="', settings.errorClass, '">', settings.errorMessage, '</p>'].join(''))
                        $(settings.name, context).focus()
                        $(settings.name, context).addClass(settings.errorClass)
                        $('label[for=' + $(settings.name).attr('id') + ']', context).addClass(settings.errorClass)
                    }

                    if (errors.drawInvalid)
                        context.prepend(['<p class="', settings.errorClass, '">', settings.errorMessageDraw, '</p>'].join(''))
                }

                /**
                 * Validates the form to confirm a name was typed in the field
                 * If drawOnly also confirms that the user drew a signature
                 *
                 * @private
                 *
                 * @return {Boolean}
                 */
                function validateForm () {
                    var valid = true
                        , errors = {drawInvalid: false, nameInvalid: false}
                        , onBeforeArguments = [context, settings]
                        , onErrorArguments = [errors, context, settings]

                    if (settings.onBeforeValidate && typeof settings.onBeforeValidate === 'function') {
                        settings.onBeforeValidate.apply(self,onBeforeArguments)
                    } else {
                        onBeforeValidate.apply(self, onBeforeArguments)
                    }

                    if (settings.drawOnly && output.length < 1) {
                        errors.drawInvalid = true
                        valid = false
                    }

                    if ($(settings.name, context).val() === '') {
                        errors.nameInvalid = true
                        valid = false
                    }

                    if (settings.onFormError && typeof settings.onFormError === 'function') {
                        settings.onFormError.apply(self,onErrorArguments)
                    } else {
                        onFormError.apply(self, onErrorArguments)
                    }

                    return valid
                }

                /**
                 * Redraws the signature on a specific canvas
                 *
                 * @private
                 *
                 * @param {Array} paths the signature JSON
                 * @param {Object} context the canvas context to draw on
                 * @param {Boolean} saveOutput whether to write the path to the output array or not
                 */
                function drawSignature (paths, context, saveOutput) {
                    for(var i in paths) {
                        if (typeof paths[i] === 'object') {
                            context.beginPath()
                            context.moveTo(paths[i].mx, paths[i].my)
                            context.lineTo(paths[i].lx, paths[i].ly)
                            context.lineCap = settings.penCap
                            context.stroke()
                            context.closePath()

                            if (saveOutput && paths[i].lx) {
                                output.push({
                                    'lx' : paths[i].lx
                                    , 'ly' : paths[i].ly
                                    , 'mx' : paths[i].mx
                                    , 'my' : paths[i].my
                                })
                            }
                        }
                    }
                }

                /**
                 * Initialisation function, called immediately after all declarations
                 * Technically public, but only should be used internally
                 *
                 * @private
                 */
                function init () {
                    // Fixes the jQuery.fn.offset() function for Mobile Safari Browsers i.e. iPod Touch, iPad and iPhone
                    // https://gist.github.com/661844
                    // http://bugs.jquery.com/ticket/6446
                    if (parseFloat(((/CPU.+OS ([0-9_]{3}).*AppleWebkit.*Mobile/i.exec(navigator.userAgent)) || [0,'4_2'])[1].replace('_','.')) < 4.1) {
                        $.fn.Oldoffset = $.fn.offset;
                        $.fn.offset = function () {
                            var result = $(this).Oldoffset()
                            result.top -= window.scrollY
                            result.left -= window.scrollX

                            return result
                        }
                    }

                    // Disable selection on the typed div and canvas
                    $(settings.typed, context).bind('selectstart.signaturepad', function (e) { return $(e.target).is(':input') })
                    canvas.bind('selectstart.signaturepad', function (e) { return $(e.target).is(':input') })

                    if (!element.getContext && FlashCanvas)
                        FlashCanvas.initElement(element)

                    if (element.getContext) {
                        canvasContext = element.getContext('2d')

                        $(settings.sig, context).show()

                        if (!settings.displayOnly) {
                            if (!settings.drawOnly) {
                                $(settings.name, context).bind('keyup.signaturepad', function () {
                                    type($(this).val())
                                })

                                $(settings.name, context).bind('blur.signaturepad', function () {
                                    type($(this).val())
                                })

                                $(settings.drawIt, context).bind('click.signaturepad', function (e) {
                                    e.preventDefault()
                                    drawIt()
                                })
                            }

                            if (settings.drawOnly || settings.defaultAction === 'drawIt') {
                                drawIt()
                            } else {
                                typeIt()
                            }

                            if (settings.validateFields) {
                                if ($(selector).is('form')) {
                                    $(selector).bind('submit.signaturepad', function () { return validateForm() })
                                } else {
                                    $(selector).parents('form').bind('submit.signaturepad', function () { return validateForm() })
                                }
                            }

                            $(settings.sigNav, context).show()
                        }
                    }
                }

                $.extend(self, {
                    /**
                     * A property to store the current version of Signature Pad
                     */
                    signaturePad : '{{version}}'

                    /**
                     * Initializes SignaturePad
                     */
                    , init : function () { init() }

                    /**
                     * Allows options to be updated after initialization
                     *
                     * @param {Object} options An object containing the options to be changed
                     */
                    , updateOptions : function (options) {
                        $.extend(settings, options)
                    }

                    /**
                     * Regenerates a signature on the canvas using an array of objects
                     * Follows same format as object property
                     * @see var object
                     *
                     * @param {Array} paths An array of the lines and points
                     */
                    , regenerate : function (paths) {
                        self.clearCanvas()
                        $(settings.typed, context).hide()

                        if (typeof paths === 'string')
                            paths = JSON.parse(paths)

                        drawSignature(paths, canvasContext, true)

                        if (settings.output && $(settings.output, context).length > 0)
                            $(settings.output, context).val(JSON.stringify(output))
                    }

                    /**
                     * Clears the canvas
                     * Redraws the background colour and the signature line
                     */
                    , clearCanvas : function () { clearCanvas() }

                    /**
                     * Returns the signature as a Js array
                     *
                     * @return {Array}
                     */
                    , getSignature : function () { return output }

                    /**
                     * Returns the signature as a Json string
                     *
                     * @return {String}
                     */
                    , getSignatureString : function () { return JSON.stringify(output) }

                    /**
                     * Returns the signature as an image
                     * Re-draws the signature in a shadow canvas to create a clean version
                     *
                     * @return {String}
                     */
                    , getSignatureImage : function () {
                        var tmpCanvas = document.createElement('canvas')
                            , tmpContext = null
                            , data = null

                        tmpCanvas.style.position = 'absolute'
                        tmpCanvas.style.top = '-999em'
                        tmpCanvas.width = element.width
                        tmpCanvas.height = element.height
                        document.body.appendChild(tmpCanvas)

                        if (!tmpCanvas.getContext && FlashCanvas)
                            FlashCanvas.initElement(tmpCanvas)

                        tmpContext = tmpCanvas.getContext('2d')

                        tmpContext.fillStyle = settings.bgColour
                        tmpContext.fillRect(0, 0, element.width, element.height)
                        tmpContext.lineWidth = settings.penWidth
                        tmpContext.strokeStyle = settings.penColour

                        drawSignature(output, tmpContext)
                        data = tmpCanvas.toDataURL.apply(tmpCanvas, arguments)

                        document.body.removeChild(tmpCanvas)
                        tmpCanvas = null

                        return data
                    }

                    /**
                     * The form validation function
                     * Validates that the signature has been filled in properly
                     * Allows it to be hooked into another validation function and called at a different time
                     *
                     * @return {Boolean}
                     */
                    , validateForm : function () { return validateForm() }
                })
            }

            /**
             * Create the plugin
             * Returns an Api which can be used to call specific methods
             *
             * @param {Object} options The options array
             *
             * @return {Object} The Api for controlling the instance
             */
            $.fn.signaturePad = function (options) {
                var api = null

                this.each(function () {
                    if (!$.data(this, 'plugin-signaturePad')) {
                        api = new SignaturePad(this, options)
                        api.init()
                        $.data(this, 'plugin-signaturePad', api)
                    } else {
                        api = $.data(this, 'plugin-signaturePad')
                        api.updateOptions(options)
                    }
                })

                return api
            }

            /**
             * Expose the defaults so they can be overwritten for multiple instances
             *
             * @type {Object}
             */
            $.fn.signaturePad.defaults = {
                defaultAction : 'typeIt' // What action should be highlighted first: typeIt or drawIt
                , displayOnly : false // Initialize canvas for signature display only; ignore buttons and inputs
                , drawOnly : false // Whether the to allow a typed signature or not
                , canvas : 'canvas' // Selector for selecting the canvas element
                , sig : '.sig' // Parts of the signature form that require Javascript (hidden by default)
                , sigNav : '.sigNav' // The TypeIt/DrawIt navigation (hidden by default)
                , bgColour : '#ffffff' // The colour fill for the background of the canvas; or transparent
                , penColour : '#000000' // Colour of the drawing ink
                , penWidth : 2 // Thickness of the pen
                , penCap : 'round' // Determines how the end points of each line are drawn (values: 'butt', 'round', 'square')
                , lineColour : '#ccc' // Colour of the signature line
                , lineWidth : 2 // Thickness of the signature line
                , lineMargin : 5 // Margin on right and left of signature line
                , lineTop : 35 // Distance to draw the line from the top
                , name : '.name' // The input field for typing a name
                , typed : '.typed' // The Html element to accept the printed name
                , clear : '.clearButton' // Button for clearing the canvas
                , typeIt : '.typeIt a' // Button to trigger name typing actions (current by default)
                , drawIt : '.drawIt a' // Button to trigger name drawing actions
                , typeItDesc : '.typeItDesc' // The description for TypeIt actions
                , drawItDesc : '.drawItDesc' // The description for DrawIt actions (hidden by default)
                , output : '.output' // The hidden input field for remembering line coordinates
                , currentClass : 'current' // The class used to mark items as being currently active
                , validateFields : true // Whether the name, draw fields should be validated
                , errorClass : 'error' // The class applied to the new error Html element
                , errorMessage : 'Please enter your name' // The error message displayed on invalid submission
                , errorMessageDraw : 'Please sign the document' // The error message displayed when drawOnly and no signature is drawn
                , onBeforeValidate : null // Pass a callback to be used instead of the built-in function
                , onFormError : null // Pass a callback to be used instead of the built-in function
                , onDraw : null // Pass a callback to be used to capture the drawing process
                , onDrawEnd : null // Pass a callback to be exectued after the drawing process
            }

        }(jQuery));


    </script>
    <script>

        $.fn.signaturePad.Colour = '#fff';
    </script>


</fieldset>

<fieldset><legend>Note</legend>

    Document à envoyer dès le
    premier jour d’absence dans les 4 heures qui suivent l’heure de prise de
    fonction habituelle  et à renouveler chaque jour si besoin et par e-mail <a href="mailto:Jessica.Jimenez@lehavremetrofr">Jessica.Jimenez@lehavremetrofr </a>

</fieldset>
<center>
    <p>
        <input type="button" id="bt" onclick="print()" value="Print PDF" />
    </p>
    <button><a href="../Directory/.index.php">ENVOYER LE FORMULAIRE</a></button></center>

<form method="post" enctype="multipart/form-data" action="upload.php">
    <p>
        <input type="file" name="fichier" size="30">
        <input type="submit" name="upload" value="Uploader">
    </p>
</form>


<p>
    <input type="button" id="bt" onclick="print()" value="Print PDF" />
</p>
</body>

<script>
    function print() {
        var objFra = document.getElementById('myFrame');
        objFra.contentWindow.focus();
        objFra.contentWindow.print();
    }
</script>
</body>

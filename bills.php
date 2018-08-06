<?php include("inc/conn.php") ?>
<?php include("inc/func.php") ?>
<?php if(!isset($_COOKIE['GO'])){Locate('index.php?3R');} ?>
<?php include("inc/head.php"); ?>
<?php
	
	if(isset($_POST['fRIP']))
	{
		$admision=prepare($_POST['fRIP'],'int',$bd);
		$fecha=prepare($_POST['fFECHA'],'date',$bd);
		$identificacion=prepare($_POST['fIDENT'],'text',$bd);
		$nombre=prepare($_POST['fUSER'],'text',$bd);
		$eps=prepare($_POST['fEPS'],'text',$bd);
		$servicio=prepare($_POST['fSERV'],'text',$bd);
		$mes=prepare($_POST['fMES'],'text',$bd);
		$ano=prepare($_POST['fANO'],'text',$bd);
		
		$TOT=0;
		$RS=$bd->query("SELECT * FROM tmp_cc");
		while($RW=$RS->fetch_assoc())
		{
			$cups=prepare($RW['cod'],'text',$bd);
			$RES=$bd->query("SELECT * FROM `cups_iss2001` WHERE `CODIGO`=$cups");
			$ROW=$RES->fetch_assoc();
			$proc=prepare($ROW['DESCRIPCION'],'text',$bd);
			$T=$RW['ciru']+$RW['anes']+$RW['ayud']+$RW['sala']+$RW['mate'];
			$TOT+=$T;
			$valor=prepare($T,'double',$bd);
			$bd->query("INSERT INTO data (`admision`,`cups`,`proc`,`valor`) VALUES ($admision,$cups,$proc,$valor)");
		}
		$valor=prepare($TOT,'double',$bd);
		$bd->query("INSERT INTO cc (`admision`,`fecha`,`identificacion`,`nombre`,`eps`,`servicio`,`valor`,`mes`,`ano`) VALUES ($admision,$fecha,$identificacion,$nombre,$eps,$servicio,$valor,$mes,$ano)");
	}
	$bd->query("TRUNCATE `tmp_cc`");
?>
<section class="content">
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<h4>Crear Cuenta de Cobro</h4>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-5">
							<div class="input-group">
								<div class="input-group-addon"><i class="far fa-calendar-times"></i></div>
								<select class="form-control" id="cboMesCC">
									<option value="0" disabled>Seleccione Mes</option>
									<?php
										$MES=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
										for ($i=0; $i < 12; $i++)
										{ 
											$S = ((date('n')-1)==($i+1)) ? 'selected' : '' ;
											echo '<option '.$S.' value="'.($i+1).'">'.$MES[$i].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="input-group">
								<div class="input-group-addon"><i class="far fa-calendar-times"></i></div>
								<select class="form-control" id="cboAnoCC">
									<option value="0" disabled>Seleccione Año</option>
									<?php
										for ($i=2016; $i <= date('Y'); $i++)
										{ 
											$S = (date('Y')==$i) ? 'selected' : '' ;
											echo '<option '.$S.' value="'.($i).'">'.$i.'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<a id="CreateCC" class="btn btn-default"><i class="fas fa-marker"></i> Crear</a>
						</div>
					</div>
					<hr class="hr-h">
					<div class="row Esconder" style="">
						<div class="col-lg-3 espacio-1">
							<div class="input-group">
								<div class="input-group-addon"><i class="fas fa-barcode"></i></div>
								<input type="text" class="form-control" id="CUPS" placeholder="Codigo">
							</div>
						</div>
						<div class="col-lg-7 espacio-1">
							<div class="input-group">
								<div class="input-group-addon"><i class="fas fa-search-plus"></i></i></div>
								<input type="text" class="form-control" name="PROCdet" required="" id="PROCdet" placeholder="Procedimiento">
								<div class="input-group-addon btn-primary data"><i class="fas fa-share-square"></i></div>
							</div>
						</div>
						<div class="col-lg-1 espacio-1">
							<div class="input-group">
	                            <div class="input-group-addon check-control1"><i class="fas fa-random"></i></div>
	                            <div class="form-control check-control"><input type="checkbox" name="Bilatelal" id="Bilatelal"></div>
	                        </div>
						</div>
					</div>
					<div class="row Esconder" style="">
						<div class="col-lg-12">
							<table id="LiquidacionISS2001" class="table table-hover" style="font-size: 11px !important">
								<thead>
									<tr>
										<th>CODIGO</th>
										<th>PROCEDIMIENTO</th>
										<th>UVR</th>
										<th><abbr title="HONORARIOS CIRUJANO">CIRUJ</abbr></th>
										<th><abbr title="HONORARIOS ANESTESIOLOGO">ANEST</abbr></th>
										<th><abbr title="HONORARIOS AYUDANTIA">AYUD</abbr></th>
										<th><abbr title="DERECHOS DE SALA">SALA</abbr></th>
										<th><abbr title="MATRIALES QUIRURGICOS">MAT</abbr></th>
										<th colspan="2">TOTAL</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
								<tfoot>
									<tr>
										<th colspan="8">TOTALES</th>
										<th colspan="2" id="TOTGRAL">0</th>
									</tr>
								</tfoot>
							</table>
							<span class="DetCUPS"></span>
						</div>
					</div>
					<div class="row Esconder" style="">
						<div class="col-lg-12">
							<a id="AdiccionarCuenta" data-toggle="modal" data-target="#MOdalChargeCC" class="btn btn-default"><i class="fas fa-plus-square"></i> Adiccionar</a>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<h4>Cuentas de Cobro</h4>
					</div>
				</div>
				<div class="panel-body">
					<?php
						$RS=$bd->query("SELECT DISTINCT mes,ano FROM cc ORDER BY mes,ano");
						while($RW=$RS->fetch_assoc())
						{
							echo '<a href="CC.php" target="_blank"><p>'.$MES[$RW["mes"]-1].'-'.$RW["ano"].'</p></a>';
						}
					?>
				</div>
			</div>
        </div>
	</div>
</section>
<style>
.modal-dialog{
  width: 300px;
}
</style>
<div class="modal fade" id="MOdalChargeCC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cargar a Cuenta de Cobro</h4>
			</div>
			<div class="modal-body">
				<form id="formulario" action="bills.php" method="post">
					<?php
						$D=array(
							"URG"=>"URGENCIAS",
							"PRG"=>"PROGRAMADA",
							"CEX"=>"C. EXTERNA"
						);
						select('<i class="far fa-clipboard"></i>','fSERV',$D,"PRG","SERVICIO...",'required');
						ctrl('<i class="fas fa-file-invoice-dollar"></i>','fRIP','Admisión','','required');
						ctrl('<i class="fas fa-id-card"></i>','fFECHA','Fecha','','required','date');
						ctrl('<i class="fas fa-id-card"></i>','fIDENT','Identificación','','required');
						ctrl('<i class="fas fa-user"></i>','fUSER','Usuario','','required');
						$RS=$bd->query("SELECT * FROM eps order by eps");
						ctrl('<i class="far fa-folder-open"></i>','fEPS','EPS');
					?>
					<input type="hidden" value="" name="fMES" id="fMES">
					<input type="hidden" value="" name="fANO" id="fANO">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary">Cargar</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include("inc/pref.php") ?>
<script type="text/javascript">
	var UVR=0;
	var CIRJ=0;
	var ANES=0;
	var AYUD=0;
	var SALA=0;
	var MATE=0;
	var TOT=0;
	var TOTGRAL=0;
	var TEMPOCC;
    var archivoValidacion = "proc.php?jsoncallback=?";
	
	  $( function() {
		var availableTags = [
		  'ABLACION DE LESION CORIORETINAL, POR DIATERMIA O CRIOTERAPIA - 142101',
'ABLACION DE LESION CORIORETINAL, POR FOTOCOAGULACION - 142300',
'ABLACION DE LESION O TEJIDO DE CONJUNTIVA, POR DIATERMIA O CRIOCOAGULACION - 103201',
'BIOPSIA DE CONJUNTIVA - 102100',
'BIOPSIA DE CORNEA - 112200',
'BIOPSIA DE CUERPO CILIAR - 122400',
'BIOPSIA DE ESCLEROTICA - 122300',
'BIOPSIA DE IRIS - 122200',
'CAPSULOTOMIA - 136501',
'CAUTERIZACION DE CORNEA - 114200',
'CICLODIALISIS - 125500',
'CONJUNTIVODACRIOCISTORRINOSTOMIA CON INTUBACION VIA EXTERNA - 98301',
'CONJUNTIVODACRIOCISTORRINOSTOMIA SIMPLE VIA EXTERNA - 98201',
'COREOPLASTIA - 123500',
'CORNOESCLERORRAFIA - 115101',
'DACRIOCISTECTOMIA - 96100',
'DACRIOCISTORRINOSTOMIA VIA EXTERNA - 98101',
'DIVISION DE SIMBLEFARON - 105100',
'DRENAJE DE SACO LAGRIMAL - 95300',
'ESCLEROQUERATOPLASTIA - 116400',
'EXTRACCION DE CUERPO EXTRAÑO INCRUSTADO EN CONJUNTIVA, POR INCISION - 100100',
'EXTRACCION DE CUERPO EXTRAÑO INTRAOCULAR DEL SEGMENTO ANTERIOR DE OJO - 120000',
'EXTRACCION DE CUERPO EXTRAÑO PROFUNDO EN CORNEA, POR INCISION - 111100',
'EXTRACCION DE LENTE INTRAOCULAR - 138100',
'EXTRACCION EXTRACAPSULAR DE CRISTALINO CON IMPLANTE DE LENTE INTRAOCULAR SUTURADO - 137100',
'EXTRACCION EXTRACAPSULAR DE CRISTALINO EN PRESENCIA DE AMPOLLA FILTRANTE PREVIA - 132400',
'EXTRACCION EXTRACAPSULAR DE CRISTALINO POR ASPIRACION - 132200',
'EXTRACCION EXTRACAPSULAR DE CRISTALINO POR FACOEMULSIFICACION - 132300',
'EXTRACCION INTRACAPSULAR DE CRISTALINO - 131100',
'GONIOTOMIA - 125100',
'IDENTACION ESCLERAL CON IMPLANTACION Y CRIOTERAPIA - 144101',
'IDENTACION ESCLERAL CON IMPLANTACION, TAMPONAMIENTO INTERNO CON GAS Y CRIOTERAPIA - 144102',
'IDENTACION ESCLERAL CON IMPLANTACION, TAMPONAMIENTO INTERNO CON GAS Y FOTOCOAGULACION - 144103',
'IMPLANTE DE LENTE INTRAOCULAR SECUNDARIO - 137200',
'IMPLANTE DE PROTESIS CORNEANA - 117300',
'INSERCION DE IMPLANTE PARA GLAUCOMA - 126700',
'IRIDECTOMIA - 121400',
'IRIDOPLASTIA, CON SUTURA - 123001',
'PERITOMIA TOTAL - 103108',
'PLASTIA DE CANALICULOS LAGRIMALES - 97100',
'PLASTIA DE PUNTO LAGRIMAL [CIRUGIA DE WEBER] - 97200',
'PLASTIA DE PUNTO LAGRIMAL MODIFICADA - 97300',
'PLASTIAS EN ESCLERA - 128800',
'QUERATECTOMIA - 117600',
'QUERATOPIGMENTACION - 118100',
'QUERATOPLASTIA LAMELAR O SUPERFICIAL - 116100',
'QUERATOPLASTIA PENETRANTE - 116200',
'QUERATOPLASTIA PENETRANTE, COMBINADA CON CIRUGIA DE CATARATA,ANTIGLAUCOMATOSA O LENTE INTRAOCULAR [CIRUGIA TRIPLE] - 116300',
'REDUCCION DE HERNIA DE IRIS, POR SUTURA DE IRIS - 121301',
'REPARACION DE COLOBOMA DEL IRIS - 123701',
'REPARACION DE DESGARRO RETINAL POR DIATERMIA O CRIOTERAPIA - 143101',
'REPARACION DE DESGARRO RETINAL POR FOTOCOAGULACION - 143300',
'REPARACION DE DESHISCENCIA DE HERIDA POS OPERATORIA CORNEAL - 115200',
'REPARACION DE DESPRENDIMIENTO DE RETINA, CON DIATERMIA O CRIOTERAPIA - 145101',
'REPARACION DE DESPRENDIMIENTO DE RETINA, CON FOTOCOAGULACION - 145300',
'REPARACION DE LACERACION O HERIDA CORNEAL CON INJERTO ESPESOR PARCIAL - 115301',
'REPARACION DE LACERACION O HERIDA CORNEAL CON INJERTO ESPESOR TOTAL - 115302',
'REPARACION DE SIMBLEFARON CON INJERTO DE MUCOSA EXTRAOCULAR - 104400',
'REPARACION DE SIMBLEFARON CON INJERTO LIBRE DE CONJUNTIVA - 104100',
'REPARACION O SUTURA DE IRIDODIALISIS - 123400',
'RESECCION DE PTERIGION REPRODUCIDO , CON PLASTIA LIBRE O CITOSTATICOS - 103105',
'RESECCION DE PTERIGION SIMPLE CON INJERTO - 103104',
'RESECCION DE PTERIGION SIMPLE CON SUTURA - 103103',
'RESECCION DE QUISTE O TUMOR BENIGNO DE CONJUNTIVA - 103101',
'RESECCION DE QUISTE O TUMOR BENIGNO DE CONJUNTIVA CON INJERTO DE MUCOSA O MEMBRANA AMNIOTICA - 103102',
'RESECCION DE TUMOR DE CUERPO CILIAR - 124401',
'RESECCION DE TUMOR DE IRIS - 124201',
'RESECCION DE TUMOR DE LA ESCLEROTICA, POR DIATERMIA O CRIOTERAPIA - 128402',
'RESECCION DE TUMOR DE LA ESCLEROTICA, VIA ABIERTA - 128401',
'RESECCION DE TUMOR MALIGNO DE CONJUNTIVA, CON PLASTIA - 103106',
'RESECCION DE TUMOR MALIGNO DE CONJUNTIVA, SIN PLASTIA - 103107',
'RETIRO DE MATERIAL IMPLANTADO DEL SEGMENTO POSTERIOR DE OJO - 146100',
'RETIRO DE SUTURA EN CORNEA - 115800',
'REVISION ANTERIOR DE TUBO DE IMPLANTE - 126705',
'REVISION DE AMPOLLA FILTRANTE CON AGUJA - 126601',
'SUTURA DE CORNEA - 115100',
'SUTURA DE LA CONJUNTIVA - 106100',
'SUTURA DE LA ESCLERA - 128100',
'TRABECULECTOMIA PRIMARIA - 126400',
'TRABECULECTOMIA SECUNDARIA - 126401',
'TRABECULOTOMIA - 125400',
'VITRECTOMIA VIA ANTERIOR CON VITRIOFAGO - 147301',
'VITRECTOMIA VIA POSTERIOR CON INSERCION DE SILICON O GASES - 147401',
'VITRECTOMIA VIA POSTERIOR CON RETINOPEXIA - 147402'
		];
		$( "#PROCdet" ).autocomplete({
		  source: availableTags
		});
	  } );
	
    $(document).ready(function(){
		$("#fMES").val($("#cboMesCC").val());
		$("#fANO").val($("#cboAnoCC").val());
		$("#cboAnoCC").change(function(){
			$("#fANO").val($("#cboAnoCC").val());
		});
		$("#cboMesCC").change(function(){
			$("#fMES").val($("#cboMesCC").val());
		});
		$("#fRIP").blur(function(){
			var FindData=$("#fSERV").val();
			var ADM=$("#fRIP").val();
			$.getJSON( archivoValidacion, { FindData:FindData,ADM:ADM })
			.done(function(D) {
				$("#fFECHA").val(D.FCH);
				$("#fIDENT").val(D.IDN);
				$("#fUSER").val(D.NOM);
				$("#fEPS").val(D.EPS);
			});
		});
        $("#AdiccionarCuenta").click(function(){
        	var Factura=$("#FACT").val();
        	var Cliente=$("#NAMEUSER").val();
        	var ADDtoCC='set';
        	$.getJSON( archivoValidacion, { ADDtoCC:ADDtoCC,Factura:Factura,Cliente:Cliente })
			.done(function(D) {

			});
		});
        $("#CreateCC").click(function(){
			$(".Esconder").fadeIn();
		});
		$(".data").click(function(){
			var CUP=$("#PROCdet").val().split(" - ");
			var CUPS=CUP[1];
			if(CUPS!='')
			{
				$.getJSON( archivoValidacion, { CUPS:CUPS })
				.done(function(D) {
					if(D.RTA=='OK')
					{
						UVR=parseInt(D.UVR);
						if(UVR>1000)
						{
							CIRJ = 0; 
							ANES = 0; 
							AYUD = 0; 
							SALA = 0; 

							TOT = prompt("Digite el Valor del Servicio, "+D.NOM, UVR);
							MATE = TOT;

							TOTGRAL += parseInt(TOT);
						}
						else
						{

							CIRJ=1270*UVR;
							ANES=960*UVR;
							AYUD = (UVR >= 50) ? (360*UVR) : 0;
							//SALA
							if(UVR>=0 && UVR<=20) { SALA=12890;}
							if(UVR>=21 && UVR<=30) { SALA=26790;}
							if(UVR>=31 && UVR<=40) { SALA=44270;}
							if(UVR>=41 && UVR<=50) { SALA=55605;}
							if(UVR>=51 && UVR<=60) { SALA=81175;}
							if(UVR>=61 && UVR<=70) { SALA=96520;}
							if(UVR>=71 && UVR<=80) { SALA=114830;}
							if(UVR>=81 && UVR<=90) { SALA=129655;}
							if(UVR>=91 && UVR<=100) { SALA=144645;}
							if(UVR>=101 && UVR<=110) { SALA=148545;}
							if(UVR>=111 && UVR<=130) { SALA=153075;}
							if(UVR>=131 && UVR<=150) { SALA=186410;}
							if(UVR>=151 && UVR<=170) { SALA=204700;}
							if(UVR>=171 && UVR<=200) { SALA=246970;}
							if(UVR>=201 && UVR<=230) { SALA=279405;}
							if(UVR>=231 && UVR<=260) { SALA=318255;}
							if(UVR>=261 && UVR<=290) { SALA=356455;}
							if(UVR>=291 && UVR<=320) { SALA=401015;}
							if(UVR>=321 && UVR<=350) { SALA=445560;}
							if(UVR>=351 && UVR<=380) { SALA=471015;}
							if(UVR>=381 && UVR<=410) { SALA=503460;}
							if(UVR>=411 && UVR<=450) { SALA=548020;}
							//MAteriales
							if(UVR>=0 && UVR<=20) { MATE=31000;}
							if(UVR>=21 && UVR<=30) { MATE=32005;}
							if(UVR>=31 && UVR<=40) { MATE=33110;}
							if(UVR>=41 && UVR<=50) { MATE=45305;}
							if(UVR>=51 && UVR<=60) { MATE=57410;}
							if(UVR>=61 && UVR<=70) { MATE=82315;}
							if(UVR>=71 && UVR<=80) { MATE=88610;}
							if(UVR>=81 && UVR<=90) { MATE=95015;}
							if(UVR>=91 && UVR<=100) { MATE=109205;}
							if(UVR>=101 && UVR<=110) { MATE=123310;}
							if(UVR>=111 && UVR<=130) { MATE=131115;}
							if(UVR>=131 && UVR<=150) { MATE=140120;}
							if(UVR>=151 && UVR<=170) { MATE=152910;}

							CIRJ += CIRJ * 0.309; 
							ANES += ANES * 0.309; 
							AYUD += AYUD * 0.309; 
							SALA += SALA * 0.309; 
							MATE += MATE * 0.309;

							var Cant=$(".Delete").length;

							if(Cant>=1)
							{
								if($('#Bilatelal').prop('checked'))
								{
									CIRJ = CIRJ * 0.75; 
									ANES = ANES * 0.75; 
									AYUD = AYUD * 0.75; 
									SALA = SALA * 0.75; 
									MATE = MATE * 0.75;
								}
								else
								{
									CIRJ = CIRJ * 0.5; 
									ANES = ANES * 0.5; 
									AYUD = AYUD * 0.5; 
									SALA = SALA * 0.5; 
									MATE = MATE * 0.5;
								}
							}

							CIRJ = Math.round(CIRJ); 
							ANES = Math.round(ANES); 
							AYUD = Math.round(AYUD); 
							SALA = Math.round(SALA); 
							MATE = Math.round(MATE);

							TOT=CIRJ+ANES+AYUD+SALA+MATE;
							TOTGRAL += TOT;
						}
						var TD='';
						TD = TD+'<tr>';
						TD = TD+'<td>'+CUPS+'</td>';
						TD = TD+'<td>'+D.NOM+'</td>';
						TD = TD+'<td>'+D.UVR+'</td>';
						TD = TD+'<td>'+CIRJ+'</td>';
						TD = TD+'<td>'+ANES+'</td>';
						TD = TD+'<td>'+AYUD+'</td>';
						TD = TD+'<td>'+SALA+'</td>';
						TD = TD+'<td>'+MATE+'</td>';
						TD = TD+'<td>'+TOT+'</td>';
						TD = TD+'<td class="Delete" data-cups="'+CUPS+'" data-val="'+TOT+'"><A class="btn btn-danger btn-xs btn-xxs"><i class="fas fa-minus-circle"></i></A></td>';
						TD = TD+'<tr>';

						$("#LiquidacionISS2001 tbody").append(TD);
						$("#TOTGRAL").text(TOTGRAL);
						$("#PROCdet").val("");
						$("#Bilatelal").removeAttr("checked");

						//crear en el temporal
						TEMPOCC='ADD';
						$.getJSON( archivoValidacion, { TEMPOCC:TEMPOCC,CUPS:CUPS,CIRJ:CIRJ,ANES:ANES,AYUD:AYUD,SALA:SALA,MATE:MATE })
						.done(function(D) {console.log("Se proceso la adiccion");});
					}
					else
					{
						alert("CODIGO CUPS INVALIDO");
						$("#CUPS").val("");
						$("#Bilatelal").removeAttr("checked");
					}
				});
			}
		});
		$("#CUPS").keypress(function(e) {
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code==13){
				var CUPS=$("#CUPS").val();
				if(CUPS!='')
				{
					$.getJSON( archivoValidacion, { CUPS:CUPS })
					.done(function(D) {
						if(D.RTA=='OK')
						{
							UVR=parseInt(D.UVR);
							if(UVR>1000)
							{
								CIRJ = 0; 
								ANES = 0; 
								AYUD = 0; 
								SALA = 0; 
								
								TOT = prompt("Digite el Valor del Servicio, "+D.NOM, UVR);
								MATE = TOT;

								TOTGRAL += parseInt(TOT);
							}
							else
							{
								
								CIRJ=1270*UVR;
								ANES=960*UVR;
								AYUD = (UVR >= 50) ? (360*UVR) : 0;
								//SALA
								if(UVR>=0 && UVR<=20) { SALA=12890;}
								if(UVR>=21 && UVR<=30) { SALA=26790;}
								if(UVR>=31 && UVR<=40) { SALA=44270;}
								if(UVR>=41 && UVR<=50) { SALA=55605;}
								if(UVR>=51 && UVR<=60) { SALA=81175;}
								if(UVR>=61 && UVR<=70) { SALA=96520;}
								if(UVR>=71 && UVR<=80) { SALA=114830;}
								if(UVR>=81 && UVR<=90) { SALA=129655;}
								if(UVR>=91 && UVR<=100) { SALA=144645;}
								if(UVR>=101 && UVR<=110) { SALA=148545;}
								if(UVR>=111 && UVR<=130) { SALA=153075;}
								if(UVR>=131 && UVR<=150) { SALA=186410;}
								if(UVR>=151 && UVR<=170) { SALA=204700;}
								if(UVR>=171 && UVR<=200) { SALA=246970;}
								if(UVR>=201 && UVR<=230) { SALA=279405;}
								if(UVR>=231 && UVR<=260) { SALA=318255;}
								if(UVR>=261 && UVR<=290) { SALA=356455;}
								if(UVR>=291 && UVR<=320) { SALA=401015;}
								if(UVR>=321 && UVR<=350) { SALA=445560;}
								if(UVR>=351 && UVR<=380) { SALA=471015;}
								if(UVR>=381 && UVR<=410) { SALA=503460;}
								if(UVR>=411 && UVR<=450) { SALA=548020;}
								//MAteriales
								if(UVR>=0 && UVR<=20) { MATE=31000;}
								if(UVR>=21 && UVR<=30) { MATE=32005;}
								if(UVR>=31 && UVR<=40) { MATE=33110;}
								if(UVR>=41 && UVR<=50) { MATE=45305;}
								if(UVR>=51 && UVR<=60) { MATE=57410;}
								if(UVR>=61 && UVR<=70) { MATE=82315;}
								if(UVR>=71 && UVR<=80) { MATE=88610;}
								if(UVR>=81 && UVR<=90) { MATE=95015;}
								if(UVR>=91 && UVR<=100) { MATE=109205;}
								if(UVR>=101 && UVR<=110) { MATE=123310;}
								if(UVR>=111 && UVR<=130) { MATE=131115;}
								if(UVR>=131 && UVR<=150) { MATE=140120;}
								if(UVR>=151 && UVR<=170) { MATE=152910;}
								
								CIRJ += CIRJ * 0.309; 
								ANES += ANES * 0.309; 
								AYUD += AYUD * 0.309; 
								SALA += SALA * 0.309; 
								MATE += MATE * 0.309;
								
								var Cant=$(".Delete").length;
								
								if(Cant>=1)
								{
									if($('#Bilatelal').prop('checked'))
									{
										CIRJ = CIRJ * 0.75; 
										ANES = ANES * 0.75; 
										AYUD = AYUD * 0.75; 
										SALA = SALA * 0.75; 
										MATE = MATE * 0.75;
									}
									else
									{
										CIRJ = CIRJ * 0.5; 
										ANES = ANES * 0.5; 
										AYUD = AYUD * 0.5; 
										SALA = SALA * 0.5; 
										MATE = MATE * 0.5;
									}
								}
								
								CIRJ = Math.round(CIRJ); 
								ANES = Math.round(ANES); 
								AYUD = Math.round(AYUD); 
								SALA = Math.round(SALA); 
								MATE = Math.round(MATE);
								
								TOT=CIRJ+ANES+AYUD+SALA+MATE;
								TOTGRAL += TOT;
							}
							var TD='';
							TD = TD+'<tr>';
							TD = TD+'<td>'+CUPS+'</td>';
							TD = TD+'<td>'+D.NOM+'</td>';
							TD = TD+'<td>'+D.UVR+'</td>';
							TD = TD+'<td>'+CIRJ+'</td>';
							TD = TD+'<td>'+ANES+'</td>';
							TD = TD+'<td>'+AYUD+'</td>';
							TD = TD+'<td>'+SALA+'</td>';
							TD = TD+'<td>'+MATE+'</td>';
							TD = TD+'<td>'+TOT+'</td>';
							TD = TD+'<td class="Delete" data-cups="'+CUPS+'" data-val="'+TOT+'"><A class="btn btn-danger btn-xs btn-xxs"><i class="fas fa-minus-circle"></i></A></td>';
							TD = TD+'<tr>';
							
							$("#LiquidacionISS2001 tbody").append(TD);
							$("#TOTGRAL").text(TOTGRAL);
							$("#CUPS").val("");
							$("#Bilatelal").removeAttr("checked");
							
							//crear en el temporal
							TEMPOCC='ADD';
							$.getJSON( archivoValidacion, { TEMPOCC:TEMPOCC,CUPS:CUPS,CIRJ:CIRJ,ANES:ANES,AYUD:AYUD,SALA:SALA,MATE:MATE })
							.done(function(D) {console.log("Se proceso la adiccion");});
						}
						else
						{
							alert("CODIGO CUPS INVALIDO");
							$("#CUPS").val("");
							$("#Bilatelal").removeAttr("checked");
						}
					});
				}
			}
		});
    });
	$(document).on("click",".Delete",function(){
		var Resta = $(this).attr("data-val");
        var parent = $(this).parents().get(0);
        CUPS = $(this).attr("data-cups");
		$(parent).remove();
		TOTGRAL -= Resta;
		$("#TOTGRAL").text(TOTGRAL);
		TEMPOCC='DEL';
		
		$.getJSON( archivoValidacion, { TEMPOCC:TEMPOCC,CUPS:CUPS,CIRJ:CIRJ,ANES:ANES,AYUD:AYUD,SALA:SALA,MATE:MATE })
		.done(function(D) {console.log("Se proceso la eliminacion");});
    });
</script>
<?php include("inc/foot.php") ?>

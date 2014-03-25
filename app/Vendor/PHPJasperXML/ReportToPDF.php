<?php
//importa classes
App::import('Vendor','PHPJasperXML/class/tcpdf/tcpdf');
App::import('Vendor','PHPJasperXML/class/PHPJasperXML');
App::import('Model','ConnectionManager'); 

class ReportToPDF
 {

/**
 * Classe responsavel por fazer a ligação entre biblioteca de conversão arquivo Jasper(jrxml) para pdf
 * Obs: deve ser criada uma pasta chamada reports em webroot/ devera ficar como webroot/reports
 * 
 * Simple usage::
 * ReportToPDF::generateReport(ARRAY('param_1'=>1), "nome_do_relatorio_.jrxml");
 *
 * Full usage::
 * ReportToPDF::generateReport(ARRAY('param_1'=>1, 'param2' => 2, 'param_N'=> 'N'), "nome_do_relatorio_.jrxml", $option_driver, $ouput);

 * @param array  $params parametros p/ o relatorio 
 * @param String $report_name nome do relatorio
 * @param Int    $output maneira como é gerado relatorio, 1 => 'Standart PDF', 2 => 'Download PDF'
 * @param String $file_name nome do arquivo .pdf gerado default 'report' 
 */
  static function generateReport($params = '', $report_name = NULL, $output = '', $name_report = 'report') {

	/***********************
	 * 		DEFAULTS
	 ***********************/
	//diretorio das imagens sao default 
	$params_default = array('IMG_EXPRESSION1' => '../webroot/img/logo1.jpg',
							'IMG_EXPRESSION2' => '../webroot/img/logo2.jpg',
							'IMG_EXPRESSION3' => '../webroot/img/logo3.jpg',
							'IMG_EXPRESSION4' => '../webroot/img/logo4.jpg',
							'SUBREPORT_DIR'   => '../webroot/reports/'
							);		
							// + "report1_subreport2.jasper"
	//diretorio dos relatorios
	$location_file = "../webroot/reports/".$report_name;
	

	/***********************
	 * 		VALIDATIONS
	 ***********************/
	//parametros para relatorio se for informado
	if(isset($params) && $params !='')
	{
		if(! is_array($params)) //tem que ser array
		{
			throw new NotFoundException('Parametros tem que estar em formato de array');				
		}
		else//faz uma uniao entre array de parametros do usuario e defaults do relatorio 
		{
			$params_default = array_merge($params, $params_default);									
		}			
	}

	//nao foi informado nome do relatorio
	if(! isset($report_name) && $report_name != '')
	{
		throw new NotFoundException('Informar nome do relatório!');
	}
	//nao foi encontrado o relatorio	
	if(! file_exists($location_file))
	{
		throw new NotFoundException('Relatório inexistente');
	}
	
	//verifica parametro opcao de geracao do relaorio
	if(isset($output) && $output !='')
	{
		if((!is_numeric($output) ) || (!($output== 1 || $output == 2)))
			throw new NotFoundException('Escolher uma saida válida para o relatório: 1 => Standart, 2=> Download');
	}
		//verifica como gerar o pdf
		switch ( $output )  
		{
			case   1: $output = 'I'; break; //Standart
			case   2: $output = 'D' ; break; //Download
			default : $output = 'D' ; break; //Download
		}
	
	
	//pega parametros de conexao definidos em Config/database.php
	$host      		= ConnectionManager::getDataSource('default')->config['host'];
	$login     	    = ConnectionManager::getDataSource('default')->config['login'];
	$password 		= ConnectionManager::getDataSource('default')->config['password'];
	$database 		= ConnectionManager::getDataSource('default')->config['database'];		

	//carrega arquivo xml
	$xml			=  simplexml_load_file($location_file);
	
	//configuracoes default p/ gerar o relatorio
	$PHPJasperXML   = new PHPJasperXML("en","TCPDF");
	$PHPJasperXML->debugsql=false;
	$PHPJasperXML->arrayParameter= $params_default; //parametros que vao p/ o relatorio no formato de array
	
	$PHPJasperXML->xml_dismantle($xml);
	$PHPJasperXML->transferDBtoArray($host, $login, $password, $database); // 1: server, 2: user, 3: password, 4: db_name, 5: driver default 'mysql'  
	$PHPJasperXML->outpage($output, $name_report);    //page output method I:standard output  D:Download file

    }
}
?>

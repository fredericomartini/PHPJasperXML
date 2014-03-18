<?php
class ReportToPDF
 {

/**
 * Classe responsavel por fazer a ligação entre biblioteca de conversão arquivo Jasper(jrxml) para pdf
 * Simple usage::
 * $relatorio = new RelatorioPDF(ARRAY('USUARIO_ID'=>1), "nome_do_relatorio_.jrxml");
 * 
 * @param array  parametros p/ o relatorio 
 * @param String nome do relatorio
 */
function ReportToPDF($params, $report_name = NULL) {
	//diretorio dos relatorios
	$location_file = "../webroot/reports/".$report_name;
	debug($location_file);
	//parametros nao sao um array
	if(! is_array($params))
	{
		throw new NotFoundException('Parametros tem que estar no formato de array');
	}
	//nao foi informado nome do relatorio
	if(! isset($report_name) && $report_name != '')
	{
		throw new NotFoundException('Informar nome do relatorio!');
	}
	//nao foi encontrado o relatorio	
	if(! file_exists($location_file))
	{
		throw new NotFoundException('Relatorio inexistente');
	}
	//pega parametros de conexao definidos em Config/database.php
	$host      = ConnectionManager::getDataSource('default')->config['host'];
	$login     = ConnectionManager::getDataSource('default')->config['login'];
	$password  = ConnectionManager::getDataSource('default')->config['password'];
	$database  = ConnectionManager::getDataSource('default')->config['database'];


	//descobrir maneira de utilizar App:import ou App:uses.. sei lah
	//inclui classes necessarias 
	include_once('class/tcpdf/tcpdf.php');
	include_once("class/PHPJasperXML.inc.php");
	
	//carrega arquivo xml
	$xml			=  simplexml_load_file($location_file);
	$PHPJasperXML   = new PHPJasperXML("pt","TCPDF");
	$PHPJasperXML->debugsql=false;
	$PHPJasperXML->arrayParameter= $params; //era $PHPJasperXML->arrayParameter=array('parameter' =>1);
	
	$PHPJasperXML->xml_dismantle($xml);
	$PHPJasperXML->transferDBtoArray($host, $login, $password, $database); // 1: server, 2: user, 3: password, 4: db_name, 5: driver default 'mysql'  
	$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

    }
}
?>
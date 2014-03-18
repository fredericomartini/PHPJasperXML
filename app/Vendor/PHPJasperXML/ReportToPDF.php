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
 * @param Int    $driver driver a ser utilizado 1 => 'mysql', 2 => 'postgres', 3 => 'odbc'
 * @param Int    $output maneira como é gerado relatorio, 1 => 'Standart PDF', 2 => 'Download PDF' 
 */
  static function generateReport($params = '', $report_name = NULL, $driver = '', $output = '') {

	//diretorio dos relatorios
	$location_file = "../webroot/reports/".$report_name;
	//parametros para relatorio se for informado
	if(isset($params) && $params !='')
	{
		if(! is_array($params)) //tem que ser array
			throw new NotFoundException('Parametros tem que estar em formato de array');
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
	//verifica parametro driver se nao for inteiro ou nao estiver na faixa 1, 2 e 3
	if(isset($driver) && $driver !='')
	{
		if((!is_numeric($driver) ) || (!($driver == 1 || $driver == 2 || $driver == 3) ) )
			throw new NotFoundException('Escolher um driver valido: 1 => MySql, 2=> Postgres, 3=> odbc');
	}
		//verifica opcao de driver		
		switch ( $driver) 
		{
			case   1: $driver = 'mysql'; break;
			case   2: $driver = 'psql' ; break;
			case   3: $driver = 'odbc' ; break;
			default : $driver = 'mysql'; break;
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
	$host      = ConnectionManager::getDataSource('default')->config['host'];
	$login     = ConnectionManager::getDataSource('default')->config['login'];
	$password  = ConnectionManager::getDataSource('default')->config['password'];
	$database  = ConnectionManager::getDataSource('default')->config['database'];		


	//carrega arquivo xml
	$xml			=  simplexml_load_file($location_file);
	
	//configuracoes default p/ gerar o relatorio
	$PHPJasperXML   = new PHPJasperXML("pt","TCPDF");
	$PHPJasperXML->debugsql=false;
	$PHPJasperXML->arrayParameter= $params; //parametros que vao p/ o relatorio no formato de array
	
	$PHPJasperXML->xml_dismantle($xml);
	$PHPJasperXML->transferDBtoArray($host, $login, $password, $database, $driver); // 1: server, 2: user, 3: password, 4: db_name, 5: driver default 'mysql'  
	$PHPJasperXML->outpage($output);    //page output method I:standard output  D:Download file
    }
}
?>

<?php 

/************************************************************************************************************
 * 																										    *
 * @author Frederico Martini github.com/fredericomartini 												    *
 * alterada apartir de https://code.google.com/p/jasperreportgenerate/										*
 * Classe responsavel por fazer ligação entre CakePHP e biblioteca											*
 * de geração de relatórios Jasperreportgenerate. 															*
 * Gera arquivo nos formatos 'PDF', 'HTML', 'XML', 'XLS', 'CSV', 'ODT', 'ODS' 								*
 * apartir de arquivo *.jasper, este que por sua vez é o resultado da compilação							*
 * do software JasperSoft iReport Designer  																*
 *																											*
 * É necessário definir no arquivo settings_jasper.properties os parametros de conexao						*
 * a base de dados, também é possível fazer a alteração das imagens que serão utilizadas 					*
 * nos relatórios, p/ isso somente trocar nome dos mesmos													*
 * no relatório p/ utilizar uma imagem o nome da mesma deve ser parecido como: 								*
 * IMG_REPORT_1, IMG_REPORT_2, IMG_REPORT_3, IMG_REPORT_N, cada imagem a ser utilizada						*
 * deve ser definida no arquivo de configuração: settings_jasper.properties									*
 *																											* 
 ************************************************************************************************************/

define('BASE_DIR_REPORT', WWW_ROOT.'reports/'); //define o diretorio dos relatorios
define('FILE_SETTINGS_JASPER', APP.'Vendor/JasperReportGenerate/settings_jasper.properties'); //define diretorio do arquivo de configuracao

	class JasperReportGenerate
	{
		/**
		 * 
		 * @param String $nameReportJasper name of report terminated in .jasper
		 * @param string $nameReport name of report to generated
		 * @param Array() $params optional, array of the parameters if necessary		
		 * @param string $format  optional, format of the report generated
		 * @param string $stream  optional, format of the output file, case true force download, if false renderized in browser 
		 * @param string $database optional, set a database based in file settings_jasper.properties
		 */
		public static function pdf_create($nameReportJasper, $nameReport='', $params='', $format='PDF', $stream=true, $database='default')
		{
			$outputJasperReportGenerate = array();
			$pathReport = array();

			$formatReport 	 = 0;
			$applicationType = '';
			switch ($format) 
			{
				case 'PDF':
					$formatReport = 1;
					$applicationType = 'application/pdf';
					break;
				case 'HTML':
					$formatReport = 2;
					break;
				case 'XML':
					$formatReport = 3;
					break;
				case 'XLS':
					$formatReport = 4;
					$applicationType = 'application/vnd.ms-excel';
					break;
				case 'CSV':
					$formatReport = 5;
					$applicationType = 'text/csv';
					break;
				case 'ODT':
					$formatReport = 6;
					$applicationType = 'application/msword';
					break;
				case 'ODS':
					$formatReport = 7;
					$applicationType = 'application/vnd.ms-excel';
					break;
				default:
					$formatReport = 1;
					$applicationType = 'application/pdf';
					break;
			}

			exec('pwd', $pathReport);
			$params['SUBREPORT_DIR'] = self::_getsubReportDir(BASE_DIR_REPORT.$nameReportJasper);
			$params['DATABASE'] = $database;
			
			//executa arquivo .jar p/ geracao de relatorio
			exec('java -jar '. APP.'Vendor/JasperReportGenerate/JasperReportGenerate.jar '.BASE_DIR_REPORT.$nameReportJasper.' '.($params == '' ? 'null' : '"'.str_replace('"', '\"', json_encode($params)).'"').' '.$formatReport.' '.FILE_SETTINGS_JASPER, $outputJasperReportGenerate);
			
			$pdfcontents = file_get_contents(TMP.'reports/'.$outputJasperReportGenerate[0]);
			
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: public');
			header('Content-Description: File Transfer');
			header('Content-Type: '.$applicationType); 
			header('Content-Transfer-Encoding: binary');

			if($stream) //download do arquivo
				header('Content-Disposition: attachment; filename= '.$nameReport.'.'.strtolower($format) );
			else //renderiza no browser
				header('Content-Disposition: inline; filename= '.$nameReport.'.'.strtolower($format) );
				
			echo $pdfcontents;
			unlink(TMP.'reports/'.$outputJasperReportGenerate[0]); //apaga arquivo
				
		}
		
		/**
		 * Retorna o caminho para a ser utilizado com subreport
		 * @param string caminho do relatório principal
		 * @return string caminho do diretório para subrelatório
		 */	
		private static function _getsubReportDir($pathReport)
		{
			$stringPathSubReport = '';
			foreach(explode('/', $pathReport) as $pathSubReport)
				if(!strpos($pathSubReport, '.jasper'))
					$stringPathSubReport.= $pathSubReport.'/';
					
			return $stringPathSubReport;		 
		}

	}

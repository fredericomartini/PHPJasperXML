CakePHP
=======

Cake php c/ PHPJasperXML
#Para utilizar a Biblioteca de conversao de arquivos .jrxml
basta copiar a pasta /app/Vendor/PHPJasperXML p/ sua respectiva pasta Vendor .

#Criar uma pasta em /app/webroot/ chamada reports a estrutura ficar como:
/app/webroot/reports

#Permissao de escrita na mesma, é nela que devem ficar os relatórios do jasper
arquivos .jrxml, xml;

#Para utilizar a classe de conversão tem que importar ela como em:

|| App::import('Vendor', 'PHPJasperXML/ReportToPDF');

#E a geração de relatório em PDF se dá assim:

ReportToPDF::generateReport(array($params), 'nome_relatorio.jrxml');

#onde $params são os parametros p/ enviar p/ o relatorio ex:

$params = array('CIDADE_ID' => 1, 'PESSOA_NOME', 'MARIA', ETC...)

OBS: Classe só foi testada com banco de dados Mysql
também vai com um dump da base contendo tabela de pais, estado e cidade com alguns dados.
p/ verificar a saida dos relatorios basta importar a base de dados e acessar a url:

http://localhost/PHPJasperXML/
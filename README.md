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

#add novas funcionalidades

#funcionalidade 1

para adicionar imagens ao relatorio, devem ser colocadas as imagens em webroot/img
ficando como: /app/webroot/img/

por padrão é possivel adicionar 4 imagens ao report sem ter que fazer alteração nenhuma, só
é preciso que elas tenham respectivamente seus nomes como: logo1.jpg, logo2.jpg, logo3.jpg, logo4.jpg

e no relatório posicionar elas conforme for necessário onde as imagens são referenciadas como
IMG_EXPRESSION1, IMG_EXPRESSION2, IMG_EXPRESSION3, IMG_EXPRESSION4;


#obs:
dar permissão de escrita!

#funcionalidade 2
 
nome do relatório, é possivel alterar o nome que o relatório é gerado
como em:

ReportToPDF::generateReport('', 'rpt2_grafico1.jrxml', '' , 'Relatorio');
onde os parametros são respectivamente :

#1: array() de parametros p/ o relatorio
#2: 'nome_relatorio.jrxml'
#3: '' tipo de saida 1: pdf gerado no navegador e 2 p/ fazer download automatico
#4: 'nome_relatorio_gerado.pdf' será o nome que o relatório será gerado

<html>
<head>
<meta charset="utf-8">

<script type="text/javascript">

function startTime()//вывод текущего времени и координат мыши в необходимом формате
{
if (!window.myX) {window.myX=0; window.myY=0}
var tm=new Date();
var h=format(tm.getHours());
var m=format(tm.getMinutes());
var s=format(tm.getSeconds());
var text=h+":"+m+":"+s+"; mouse x="+window.myX+", mouse y="+window.myY+";";
window.status=text;
document.getElementById('txt').innerHTML=text;
setTimeout('startTime()',200);
}
function format(i)//форматирование хх в хх , х в 0х
{
if (i<10) {i="0" + i;}
return i;
}
document.onmousemove = function(e)//обработка события движение мыши  
{
  e = e || window.event;
  myX=e.clientX;//сохранение координат для вывода в startTime()
  myY=e.clientY;
}

</script> 
</head>
<body onload="startTime()"><!--запуск таймера с выводом времени и координат-->
<script>
function func(field, needtoopen)//проход элементов формы
	{
	var nochek=true;
	document.getElementById('lal').innerHTML ="";//очистим результат
	for(i=0;i<field.length;i++)//переберем элементы формы
		{
		if(field[i].checked)//если нажата
		{
		if (needtoopen) var newWin = window.open(field[i].value, field[i].id);	
		else
		{
		nochek=false;
		document.getElementById('lal').innerHTML += field[i].value+"<br/>";//добавить ссылку в результат
		}
		}
		}
	if (nochek) {document.getElementById('lal').innerHTML ="<br/>";}
	document.getElementById('res').value = document.getElementById('lal').innerHTML;//запишем результат в элемент input type="hidden" для возможности отправки результата
	}
</script>
<?php 
if($_POST){

echo "Вами были выбраны следующие ссылки: <br>";
echo $_POST['result'];
}
//if(!$_POST) если ненадо обрабатывать ответ покажем стартовую форму
else
{
echo "<form name=\"openlist\" onChange=\"func(openlist, false);\" action=\"\" method=\"post\">";
echo "<table border=\"1\" align = \"center\">";

$num=0;
$res="";
$filename='urllist.txt';
// запросим наличия фыйла со ссылками 
// если его нет - создадим и заполним
if (!file_exists($filename))
{
$myfile=fopen($filename,"w");
fputs($myfile,"http://php.net/
http://w3.org/
http://fdo.tusur.ru/
http://startrek-russia.ru/
http://vk.com/
http://ok.ru/
http://www.my80stv.com/
http://yandex.ru/
http://google.com/
http://rambler.ru/
");
}
//<!-- -->

$lines = file($filename);//прочтем из файла список ссылок

// пройдем по ссылкам
foreach ($lines as $line_num => $line) 
{
$num++;// подсчитаем ссылки
if ($num==1) $first=$line;//первую строчку запомним
else 
$res=$res.$line;//все кроме первой запишем в результат
/*сформируем код с первыми пятью ссылками*/
if ($num < 5) echo "<tr>\n<td><input id=cb".$num." type=\"checkbox\" value=".$line."></td><td><label for=cb".$num.">".$line."</label></td>\n</tr>\n";
}
$res=$res.$first;//первую строчку запишем в конец

  $file = fopen ("urllist.txt","r+");//откроем файл для записи
  if ( !$file )
  {
    echo("Ошибка открытия файла");
  }
  else
  {
    fputs ( $file, $res);//запишем в файл обновленный список ссылок
  }
  fclose ($file);//закроем файл


echo"<tr>	<td></td><td><label id=\"lal\"><br/></label></td></tr>";


echo"<tr>	<td></td><td><INPUT TYPE=\"submit\" name=\"submit\" VALUE=\"                    Ok                    \"></td></tr></table>";
}// дальше часики, жалко их убирать
//<!--скрытый элемент для отправки списка выбраных ссылок-->
echo"<input type=\"hidden\" name=\"result\" id = \"res\" ><br /></form>";
//<!--эмулятор строки состояния-->
echo"<p id=\"txt\"> </p>";
//}
?>
</body> 
</html>
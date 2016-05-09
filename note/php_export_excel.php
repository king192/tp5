<?php
/**
* author:郭椿安
* create at:2015-11-13
* last mod: 2015-12-12 14:23:52
*/
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=xls_data.xls");
// header("Content-type:text/html;charset=utf-8"); //测试启用
  
$dbhost = 'localhost';
$dbname = 'test1';       //所在数据库名
$dbuser = 'root';
$dbpwd = 'root';
$language = 'utf8';
$tbname = 'myisam';    //要导出的表单
$style = "border='1' width='100%' cellspacing=0";//自定义表的样式,如果加CSS请使用连接符.
  
//链接数据库
$link = mysqli_connect($dbhost,$dbuser,$dbpwd,$dbname);
//设置utf8编码
mysqli_query($link,"set names ".$language);
  
//获取user表的段名和备注
$sql = "select COLUMN_NAME,COLUMN_COMMENT from INFORMATION_SCHEMA.Columns where table_name='$tbname' and table_schema='$dbname'";
$cos = mysqli_query($link,$sql);
  
echo "<table ".$style."><tr>";
//导出表头（也就是表中拥有的字段）
while($col = mysqli_fetch_assoc($cos)){
  
    if ($col['COLUMN_COMMENT']) {//取备注名组成数组，如果没有，则直接用段名
  
        $t_field[] = $col['COLUMN_COMMENT'];
        echo "<th>".$col['COLUMN_COMMENT']."</th>";
  
    }else{
        $t_field[] = $col['COLUMN_NAME'];
        echo "<th>".$col['COLUMN_NAME']."</th>";
    }
}
  
echo "</tr>";
//查出10条数据
$sql = "select * from $tbname limit 100000";
$res = mysqli_query($link,$sql);
 
while($row = mysqli_fetch_array($res)){
    echo "<tr>";
    for ($i=0; $i < count($t_field); $i++) { //循环输出一行记录
        echo "<td>".$row[$i]."</td>";
    }
    echo "</tr>";
}
echo "</table>";
  
?>
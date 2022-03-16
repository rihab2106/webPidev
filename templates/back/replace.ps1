
$path= Get-Item -Path *.html* 
foreach($c in $path){
    
    $content=(Get-Content -Path $c).replace( "assets" ,"BackAssets")
    #$content.Insert($content.IndexOf('href="'),"{{asset(")
    #$herf=$content | Select-String -Pattern 'href=' 
    #foreach ($h in $herf){
     #   $hh=([String]$h)
      #  $hh.Insert(
    #}
   # $content.Replace('href="', 'href="asset{{"')    >"t.txt"
   $content=$content.replace(".html",".html.twig")
   $content =$content -Replace('<[^a]* href="(?<f>.[^"]*)"', 'href="{{asset("${f}")}}"') 
   $content=$content -Replace('src="[^https](?<f>.[^"]*)"', 'src="{{asset("B${f}")}}"')
     
   Set-Content -path $c -Value $content 
     if (!([String]$c).Contains('twig')){
     Rename-Item -Path $c -NewName  $c".twig"
     }
}

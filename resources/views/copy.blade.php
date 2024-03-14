<!DOCTYPE html>
<html>
    <head>
        <title>Copy Notulensi</title>
       
    </head>
    <body>
<textarea onload=" $(this).select();
        document.execCommand('copy');" id="copy">Judul Agenda
{{$data->judul_agenda}}
Waktu Meeting
{{$data->waktu_meeting}}
Roadmap
{{$data->roadmap}}
Notulensi
{{$data->notulensi}}
</textarea>
    </body>
     <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
     
        
        </script>
</html>
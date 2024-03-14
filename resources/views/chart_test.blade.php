<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script type="text/javascript" src="//d3js.org/d3.v3.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.css" />
<link rel="stylesheet" href="{{asset('assets/dashboard/lte/css/adminlte.min.css')}}">
</head>
<body>
 {!! Calendar::taskGenerate(5,2021)!!}

</body>
</html>
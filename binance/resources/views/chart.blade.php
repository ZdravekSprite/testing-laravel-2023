<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : '' }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" type="image/x-icon" href="/img/binance.ico">

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
  <style>
  .floating-tooltip-2 {
    width: 85px;
    height: 130px;
    position: absolute;
    display: none;
    padding: 8px;
    box-sizing: border-box;
    font-size: 12px;
    color: #131722;
    background-color: rgba(0, 0, 0, 0.5);
    text-align: left;
    z-index: 1000;
    top: 12px;
    left: 12px;
    pointer-events: none;
    border: 1px solid rgba(255, 70, 70, 1);
    border-radius: 2px;
  }
  </style>
</head>

<body>
  <script>
    var bnb = '';
    var btc = '';
    var eth = '';

    var chartWidth = {{ $chartWidth }}; //313 470 627;
    var chartWidth_btc = {{ $chartWidth_btc }}; // 207 417
    var chartHeight = {{ $chartHeight }}; //230 310 465;

    var toolTipWidth = 100;
    var toolTipHeight = 80;
    var toolTipMargin = 15;

    @foreach($symbols as $symbol)
    var container{{ $symbol[4] }}_{{$symbol[0]}} = document.createElement('div');
    container{{ $symbol[4] }}_{{$symbol[0]}}.id = "chart{{$symbol[4]}}_{{$symbol[0]}}";
    container{{ $symbol[4] }}_{{$symbol[0]}}.style.cssText = 'float: left; padding: 1px;';

    document.body.appendChild(container{{ $symbol[4] }}_{{$symbol[0]}});

    var chart{{ $symbol[4] }}_{{ $symbol[0] }} = LightweightCharts.createChart(container{{ $symbol[4] }}_{{$symbol[0]}}, {
      @if ($symbol[0] === 'BTCBUSD')
        width: chartWidth,
      @else
        @switch($symbol[4])
          @case('1d')
            width: chartWidth_btc,
            @break

          @case('1h')
            width: chartWidth_btc,
            @break

          @default
            @switch(substr($symbol[0], -3))
              @case('BTC')
                width: chartWidth_btc,
                @break

              @default
                width: chartWidth,
            @endswitch
        @endswitch
      @endif
      height: chartHeight,
      layout: {
        backgroundColor: '#000000',
        textColor: 'rgba(255, 255, 255, 0.1)',
      },
      grid: {
        vertLines: {
          color: 'rgba(197, 203, 206, 0.5)',
        },
        horzLines: {
          color: 'rgba(197, 203, 206, 0.5)',
        },
      },
      crosshair: {
        mode: LightweightCharts.CrosshairMode.Normal,
      },
      priceScale: {
        borderColor: 'rgba(197, 203, 206, 0.8)',
      },
      rightPriceScale: {
        scaleMargins: {
          top: 0.2,
          bottom: 0.1,
        },
      },
      timeScale: {
        rightOffset: 2,
        borderColor: 'rgba(197, 203, 206, 0.8)',
        timeVisible: true,
        secondsVisible: false,
      },
    });

    chart{{ $symbol[4] }}_{{ $symbol[0] }}.applyOptions({
      watermark: {
        color: 'rgba(170, 175, 180, 0.5)',
        visible: true,
        text: '{{ $symbol[0]."_".$symbol[4] }}',
        fontSize: 22,
        horzAlign: 'left',
        vertAlign: 'top',
      },
    });

    chart{{ $symbol[4] }}_{{ $symbol[0] }}.subscribeClick(function(param){
      console.log(`An user clicks at (${param.point.x}, ${param.point.y}) point, the time is ${param.time}`);
      console.log(candleSeries{{ $symbol[4] }}_{{ $symbol[0] }}.coordinateToPrice(param.point.x));
    });

    var toolTip{{ $symbol[4] }}_{{ $symbol[0] }} = document.createElement('div');
    toolTip{{ $symbol[4] }}_{{ $symbol[0] }}.className = 'floating-tooltip-2';
    container{{ $symbol[4] }}_{{ $symbol[0] }}.appendChild(toolTip{{ $symbol[4] }}_{{ $symbol[0] }});

// update tooltip
    chart{{ $symbol[4] }}_{{ $symbol[0] }}.subscribeCrosshairMove(function(param) {
      if (!param.time || param.point.x < 0 || param.point.x > chartWidth || param.point.y < 0 || param.point.y > chartHeight) {
        toolTip{{ $symbol[4] }}_{{ $symbol[0] }}.style.display = 'none';
        return;
      }

      toolTip{{ $symbol[4] }}_{{ $symbol[0] }}.style.display = 'block';
      var price{{ $symbol[4] }}_{{ $symbol[0] }} = param.seriesPrices.get(candleSeries{{ $symbol[4] }}_{{ $symbol[0] }});

      function nFormatter(num, digits) {
        const lookup = [
          { value: 1, symbol: "" },
          { value: 1e3, symbol: "k" },
          { value: 1e6, symbol: "M" },
          { value: 1e9, symbol: "G" },
          { value: 1e12, symbol: "T" },
          { value: 1e15, symbol: "P" },
          { value: 1e18, symbol: "E" }
        ];
        const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
        var item = lookup.slice().reverse().find(function(item) {
          return num >= item.value;
        });
        return item ? (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";
      }

      var value{{ $symbol[4] }}_{{ $symbol[0] }} = param.seriesPrices.get(histogramSeries{{ $symbol[4] }}_{{ $symbol[0] }});
      //console.log(param.time);
      var txt1{{ $symbol[4] }}_{{ $symbol[0] }} = ((price{{ $symbol[4] }}_{{ $symbol[0] }}.close - price{{ $symbol[4] }}_{{ $symbol[0] }}.open ) / price{{ $symbol[4] }}_{{ $symbol[0] }}.open );
      var txt2{{ $symbol[4] }}_{{ $symbol[0] }} = ((price{{ $symbol[4] }}_{{ $symbol[0] }}.high - price{{ $symbol[4] }}_{{ $symbol[0] }}.low ) / price{{ $symbol[4] }}_{{ $symbol[0] }}.high );
      toolTip{{ $symbol[4] }}_{{ $symbol[0] }}.innerHTML = '<div style="font-size: 10px; color: rgba(255, 70, 70, 1)">{{ $symbol[0] }}</div>' +
        //'<div style="font-size: 10px; margin: 2px 0px">' + new Date(param.time * 1000) + '%</div>' +
        '<div style="font-size: 12px; margin: 2px 0px">' + (txt1{{ $symbol[4] }}_{{ $symbol[0] }}*100).toFixed(2) + '% <span style="font-size: 10px;">' + (txt2{{ $symbol[4] }}_{{ $symbol[0] }}*100).toFixed(2) + '%</span></div>' +
        '<div style="font-size: 10px; margin: 2px 0px">' + price{{ $symbol[4] }}_{{ $symbol[0] }}.high*1 + '</div>' +
        '<div style="font-size: 10px; margin: 2px 0px">' + price{{ $symbol[4] }}_{{ $symbol[0] }}.open*1 + '</div>' +
        '<div style="font-size: 10px; margin: 2px 0px">' + price{{ $symbol[4] }}_{{ $symbol[0] }}.close*1 + '</div>' +
        '<div style="font-size: 10px; margin: 2px 0px">' + price{{ $symbol[4] }}_{{ $symbol[0] }}.low*1 + '</div>' +
        '<div style="font-size: 10px; margin: 2px 0px">' + nFormatter(value{{ $symbol[4] }}_{{ $symbol[0] }}, 2) + '</div>';

      var y{{ $symbol[4] }}_{{ $symbol[0] }} = container{{ $symbol[4] }}_{{$symbol[0]}}.offsetTop + param.point.y;
      var x{{ $symbol[4] }}_{{ $symbol[0] }} = container{{ $symbol[4] }}_{{$symbol[0]}}.offsetLeft + param.point.x;

      var left{{ $symbol[4] }}_{{ $symbol[0] }} = x{{ $symbol[4] }}_{{ $symbol[0] }} + toolTipMargin;
      if (left{{ $symbol[4] }}_{{ $symbol[0] }} > chartWidth - toolTipWidth) {
        left{{ $symbol[4] }}_{{ $symbol[0] }} = x{{ $symbol[4] }}_{{ $symbol[0] }} - toolTipMargin - toolTipWidth;
      }

      var top{{ $symbol[4] }}_{{ $symbol[0] }} = y{{ $symbol[4] }}_{{ $symbol[0] }} + toolTipMargin;
      if (top{{ $symbol[4] }}_{{ $symbol[0] }} > chartHeight - toolTipHeight) {
        top{{ $symbol[4] }}_{{ $symbol[0] }} = y{{ $symbol[4] }}_{{ $symbol[0] }} - toolTipHeight - toolTipMargin;
      }

      toolTip{{ $symbol[4] }}_{{ $symbol[0] }}.style.left = left{{ $symbol[4] }}_{{ $symbol[0] }} + 'px';
      toolTip{{ $symbol[4] }}_{{ $symbol[0] }}.style.top = top{{ $symbol[4] }}_{{ $symbol[0] }} + 'px';
    });

    const histogramSeries{{ $symbol[4] }}_{{ $symbol[0] }} = chart{{ $symbol[4] }}_{{ $symbol[0] }}.addHistogramSeries({
      color: '#26a69a',
      priceFormat: {
        type: 'volume',
      },
      priceScaleId: '',
      scaleMargins: {
        top: 0.90,
        bottom: 0,
      },
    });

    const lineSeries{{ $symbol[4] }}_{{ $symbol[0] }} = chart{{ $symbol[4] }}_{{ $symbol[0] }}.addLineSeries({
      priceScaleId: 'left',
      color: '#f48fb1',
      lineStyle: 0,
      lineWidth: 1,
      drawCrosshairMarker: true,
      crosshairMarkerRadius: 1,
      lineType: 1,
    });

    const candleSeries{{ $symbol[4] }}_{{ $symbol[0] }} = chart{{ $symbol[4] }}_{{ $symbol[0] }}.addCandlestickSeries({
      upColor: '#00ff00',
      downColor: '#ff0000',
      borderDownColor: 'rgba(255, 144, 0, 1)',
      borderUpColor: 'rgba(255, 144, 0, 1)',
      wickDownColor: 'rgba(255, 144, 0, 1)',
      wickUpColor: 'rgba(255, 144, 0, 1)',
      priceFormat: { type: 'price', minMove: {{ 1/pow(10,$symbol[5]) }}, precision: {{ $symbol[5] }} },
      scaleMargins: {
        top: 1,
        bottom: 0.1,
      },
    });

    // create a horizontal price line at a certain price level.
    @if(isset($symbol[1]))
    @foreach($symbol[1] as $key => $buy)
    const buypriceLine{{ $symbol[4] }}{{ $symbol[0] }}{{ $key }} = candleSeries{{ $symbol[4] }}_{{ $symbol[0] }}.createPriceLine({
          price: {{ $buy }},
          color: 'red',
          lineWidth: 2,
          lineStyle: LightweightCharts.LineStyle.Dotted,
          axisLabelVisible: true,
    });
    @endforeach
    @endif
    @if(isset($symbol[2]))
    @foreach($symbol[2] as $key => $sell)
    const sellpriceLine{{ $symbol[4] }}{{ $symbol[0] }}{{ $key }} = candleSeries{{ $symbol[4] }}_{{ $symbol[0] }}.createPriceLine({
          price: {{ $sell }},
          color: 'green',
          lineWidth: 2,
          lineStyle: LightweightCharts.LineStyle.Dotted,
          axisLabelVisible: true,
    });
    @endforeach
    @endif

    fetch('https://api.binance.com/api/v3/klines?symbol={{ $symbol[0] }}&interval={{ $symbol[4] }}&limit=1000')
      .then((r) => r.json())
      .then((r) => {
        //console.log('response_binance', response)
        var objs = r.map(function(x) {
          return {
            time: x[0] / 1000 + 60*60,//*2,
            open: x[1],
            high: x[2],
            low: x[3],
            close: x[4],
            value: x[5]*x[4],
            color: x[1] > x[4] ? 'rgba(255,82,82, 0.8)' : 'rgba(0, 150, 136, 0.8)'
          };
        });
        console.log(objs);
        //console.log('response_data', data)
        candleSeries{{ $symbol[4] }}_{{ $symbol[0] }}.setData(objs);
        histogramSeries{{ $symbol[4] }}_{{ $symbol[0] }}.setData(objs);
        lineSeries{{ $symbol[4] }}_{{ $symbol[0] }}.setData(objs.map(function(x) {
          return {
            time: x.time,
            value: x.value*(x.close - x.open)*(x.high - x.low)
          };
        }));
      })

// set markers
    @if($symbol[4] <> '1d')
    candleSeries{{ $symbol[4] }}_{{ $symbol[0] }}.setMarkers([
      @foreach($symbol[3] as $marker)
      {
        time: {{ $marker->time + 60*60 }},//*2 }},
        position: '{{ $marker->position }}',
        color: '{{ $marker->color }}',
        shape: '{{ $marker->shape }}',
        id: '{{ $marker->id }}',
        text: '{{ $marker->text }}',
        size: 1,
      },
      @endforeach
    ]);
    @endif

    @endforeach

    // /stream?streams=<streamName1>/<streamName2>/<streamName3>
    //var binanceSocket = new WebSocket("wss://stream.binance.com:9443/ws/btcusdt@kline_1m");
    //var binanceSocket = new WebSocket("wss://stream.binance.com:9443/stream?streams=btcusdt@kline_1m/ethusdt@kline_1m/bnbusdt@kline_1m/ethbtc@kline_1m");
    var binanceSocket = new WebSocket("wss://stream.binance.com:9443/stream?streams={{ $link }}");

    binanceSocket.onmessage = function(event) {
      var message = JSON.parse(event.data);

      if (message.stream == 'bnbbusd@kline_1m') bnb = message.data.k.c*1;
      if (message.stream == 'ethbusd@kline_1m') eth = message.data.k.c*1;
      if (message.stream == 'btcbusd@kline_1m') btc = message.data.k.c*1;
      document.title = bnb + ' ' + eth + ' ' + btc;

      //console.log('message', message)
      @foreach($symbols as $symbol)
      @if($symbol[4] == '1m')
      if (message.stream == '{{ strtolower($symbol[0]) }}@kline_1m') {
        var candlestick = message.data.k;
        candleSeries1m_{{ $symbol[0] }}.update({
          time: candlestick.t / 1000 + 60*60,//*2,
          open: candlestick.o,
          high: candlestick.h,
          low: candlestick.l,
          close: candlestick.c,
        });
        histogramSeries1m_{{ $symbol[0] }}.update({
          time: candlestick.t / 1000 + 60*60,//*2,
          value: candlestick.v * candlestick.c,
          color: candlestick.o > candlestick.c ? 'rgba(255,82,82, 0.8)' : 'rgba(0, 150, 136, 0.8)'
        });
        lineSeries1m_{{ $symbol[0] }}.update({
          time: candlestick.t / 1000 + 60*60,//*2,
          value: candlestick.v * candlestick.c * (candlestick.c - candlestick.o) * (candlestick.h - candlestick.l),
        });
      }
      @endif
      @endforeach
      //var candlestick = message.k;
      //console.log('candlestick', candlestick)
    }

  </script>
</body>

</html>

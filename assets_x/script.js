function numberWithCommas(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return parts.join(".");
}

$(function () {
  class GaugeChart {
    constructor(element, params) {
      this._element = element;
      this._initialValue = params.initialValue;
      this._higherValue = params.higherValue;
      this._title = params.title;
      this._subtitle = params.subtitle;
    }

    _buildConfig(json) {
      // alert(json);
      let element = this._element;

      // var v_custom_ticks = [0];
      // for (var i = 4; i >= 0; i--) {
      //     alert(i);
      //     v_custom_ticks.push(100000000/i);
      // }
    
      var v_custom_ticks = [0];
      for (var i = 1; i < 5; i++ ) {
          //alert(i);
          v_custom_ticks.push((json[0].max_bar/5) * i);
      }
      v_custom_ticks.push(json[0].max_bar);
      // v_custom_ticks.push(json[0].max_bar/2.5);
      // v_custom_ticks.push(json[0].max_bar/4);
      // v_custom_ticks.push(json[0].max_bar/4);
      // v_custom_ticks.push(json[0].max_bar);

      return {
        value: this._initialValue,
        valueIndicator: {
          color: '#fff' },

        geometry: {
          startAngle: 180,
          endAngle: 360 },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: v_custom_ticks,
          tick: {
            length: 10 },

          label: {
            format: {
                type: 'thousands',
                // precision: 2
            },
            font: {
              color: '#87959f',
              size: 10,
              family: '"Open Sans", sans-serif' } 
            
            } },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#fff',
            size: 10 },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#fff',
              weight: 500,
              size: 18 } } },



        onInitialized: function () {
          let currentGauge = $(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        } };


    }

    init(json) {
      // alert(json);
      $(this._element).dxCircularGauge(this._buildConfig(json));
    }}


  $(document).ready(function () {

    function initial_chart(jsonx){
      // var json = '{"terminal_id":"01000900","terminal_name":"ATM IDM SKHRJA WRNG KRA","terminal_city":"SUKABUMI","location":"Sukaharja, Warung Kiara, Sukabumi, West Java 43362","date_insert":"2021-06-19 20:49:11.570","date_update":null,"user_create":"hari01","upload_file":"","jarkom":"Nosairis","cit":"ABS"}';
      // var obj = JSON.parse(jsonx);
      // const myArr = JSON.parse(text);


      // alert(jsonx[0].max_bar);
      $('.gauge').each(function (index, item) {
        //alert('gaige');
        //
        let params = {
          initialValue: jsonx[0].current_bar,
          higherValue: jsonx[0].max_bar,
          title: `Bar ATM`,
          subtitle: numberWithCommas(jsonx[0].current_bar) };
    
    
        let gauge = new GaugeChart(item, params);
        gauge.init(jsonx);
      });
    }
    
    function get_data_bar_atm() {
      // var splashArray = [];
      var url = baseURL + "chart/getsummary/ajax_get_bar_atm";
      var datapost = {
        terminal_id: '01000900'
      };
      $.getJSON(url,datapost)
          .done(function (data) {
              // $.each(data, function(index, element) {
              // splashArray.push(element.current_bar);		
              // initial_chart(element.current_bar);
              // alert(element.terminal_id);
              // });
              initial_chart(data);
            
          })
          .fail(function (jqxhr, textStatus, error) {
              var err = textStatus + ", " + error;
              alert("Request Failed 66: " + err);
          });
    }
    
    get_data_bar_atm();
    

    // $('#random').click(function () {

    //   $('.gauge').each(function (index, item) {
    //     let gauge = $(item).dxCircularGauge('instance');
    //     let randomNum = Math.round(Math.random() * 1560);
    //     let gaugeElement = $(gauge._$element[0]);

    //     gaugeElement.find('.dxg-title text').last().html(`${randomNum} ºC`);
    //     gauge.value(randomNum);
    //   });
    // });
  });

});
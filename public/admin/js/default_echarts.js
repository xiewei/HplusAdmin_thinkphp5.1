//饼图缺省配置
function pie_fun (title,unit,types,data) {
  var option = {
        title : {
            text:title,
            subtext:'值单位：'+unit,
            x:'center'
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {
                    show: true,
                    type: ['pie', 'funnel']
                },
                saveAsImage : {show: true}
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data:types
        },
        series : [
            {
                name: title,
                type: 'pie',
                label: {
                    normal: {
                            show: true,
                            // formatter:function(a){
                            //     console.log(a);
                            //     return a+"%";
                            // },
                            formatter:"{b} : {c} \n({d}%)"
                        },
                    },

                radius : '55%',
                center: ['50%', '60%'],
                data:data,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
      };

    return option;
}

//柱图缺省配置
function bar_fun (title,unit,types,month) {
    option = {
        title : {
            text: title,
            subtext:'值单位：'+unit,
        },
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data:types
        },
        toolbox: {
            show : true,
            feature : {
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data :month
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        dataZoom: [
                {
                    show: true,
                    start: 0,
                    end: 40,
                    handleSize: 10
                },
                {
                    show: true,
                    yAxisIndex: 0,
                    // filterMode: 'empty',
                    width: 12,
                    height: '70%',
                    handleSize: 8,
                    showDataShadow: false,
                    left: '93%'
                }
            ]
    };

    return option;
}







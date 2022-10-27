@extends('layouts.admin')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
  <style>
    .data .bx-devices:before {
      padding: 4px;
      background-color: rgb(255, 254, 234);
      border-radius: 10px;
      color: rgb(244, 248, 0);
    }

    .data .bx-task {
      padding: 3px;
      background-color: rgb(224, 255, 243);
      border-radius: 10px;
      color: rgb(42, 255, 184);
    }

    .data .bx-collection {
      padding: 3px;
      background-color: rgb(255, 227, 226);
      border-radius: 10px;
      color: rgb(255, 51, 51);
    }
    .data .bx-user-plus {
      padding: 2px;
      background-color: rgb(255, 234, 214);
      border-radius: 10px;
      color: rgb(255, 131, 49);
    }
  </style>
@endpush
@section('content')
  <div class="row">
    <!--/ Total Revenue -->
    <div class="col-12">
      <div class="row data">
        <div class="col-3 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <i class="menu-icon tf-icons bx bx-devices bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Services</span>
                  <h3 class="card-title text-nowrap mb-2">{{ $service }} Item</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <i class="menu-icon tf-icons bx bx-task bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Projects</span>
                  <h3 class="card-title text-nowrap mb-2">{{ $project }} Item</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <i class="menu-icon tf-icons  bx bx-collection bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Partners</span>
                  <h3 class="card-title text-nowrap mb-2">{{ $partner }} Item</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 mb-4">
            <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-4">

                      <i class="menu-icon tf-icons  bx bx-user-plus"
                        style="font-size:50px;text-align:center;height:100%"></i>
                    </div>
                    <div class="col-8">
                      <span class="d-block">Visitors Today</span>
                      <h3 class="card-title text-nowrap mb-2">{{ $visitorToday }} People</h3>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
    <!-- Total Revenue -->
    <div class="col-6  mb-4">
      <div class="card">
        <div class="row row-bordered g-0">
          <div class="col-12">
            <h4 class="card-header m-0 me-2 pb-3">Visitors by Day</h4>
            <div id="totalRevenueChart" class="px-2"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 order-1 mb-4">
      <div class="card h-100">
        <h4 class="card-header m-0 me-2 pb-3">Visitors by Month</h4>
        <div class="card-body px-0">
          <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
              <div id="incomeChart" class="p-2"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

@push('script')
  <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush

@push('js')
  <script>
    (function() {
      let cardColor, headingColor, axisColor, shadeColor, borderColor;

      cardColor = config.colors.white;
      headingColor = config.colors.headingColor;
      axisColor = config.colors.axisColor;
      borderColor = config.colors.borderColor;

      // Total Revenue Report Chart - Bar Chart
      // --------------------------------------------------------------------
      const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
        totalRevenueChartOptions = {
          series: [{
              name: '2022',
              data: [28, 32, 46, 74, 63, 35, 0]
            },

          ],
          chart: {
            height: 300,
            stacked: true,
            type: 'bar',
            toolbar: {
              show: false
            }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '33%',
              borderRadius: 12,
              startingShape: 'rounded',
              endingShape: 'rounded'
            }
          },
          colors: [config.colors.primary, config.colors.info],
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'smooth',
            width: 6,
            lineCap: 'round',
            colors: [cardColor]
          },
          legend: {
            show: true,
            horizontalAlign: 'left',
            position: 'top',
            markers: {
              height: 8,
              width: 8,
              radius: 12,
              offsetX: -3
            },
            labels: {
              colors: axisColor
            },
            itemMargin: {
              horizontal: 10
            }
          },
          grid: {
            borderColor: borderColor,
            padding: {
              top: 0,
              bottom: -8,
              left: 20,
              right: 20
            }
          },
          xaxis: {
            categories: ['17', '18', '19','20', '21', '22', '23'],
            labels: {
              style: {
                fontSize: '13px',
                colors: axisColor
              }
            },
            axisTicks: {
              show: false
            },
            axisBorder: {
              show: false
            }
          },
          yaxis: {
            labels: {
              style: {
                fontSize: '13px',
                colors: axisColor
              }
            }
          },
          responsive: [{
              breakpoint: 1700,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '32%'
                  }
                }
              }
            },
            {
              breakpoint: 1580,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '35%'
                  }
                }
              }
            },
            {
              breakpoint: 1440,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '42%'
                  }
                }
              }
            },
            {
              breakpoint: 1300,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '48%'
                  }
                }
              }
            },
            {
              breakpoint: 1200,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '40%'
                  }
                }
              }
            },
            {
              breakpoint: 1040,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 11,
                    columnWidth: '48%'
                  }
                }
              }
            },
            {
              breakpoint: 991,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '30%'
                  }
                }
              }
            },
            {
              breakpoint: 840,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '35%'
                  }
                }
              }
            },
            {
              breakpoint: 768,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '28%'
                  }
                }
              }
            },
            {
              breakpoint: 640,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '32%'
                  }
                }
              }
            },
            {
              breakpoint: 576,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '37%'
                  }
                }
              }
            },
            {
              breakpoint: 480,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '45%'
                  }
                }
              }
            },
            {
              breakpoint: 420,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '52%'
                  }
                }
              }
            },
            {
              breakpoint: 380,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    columnWidth: '60%'
                  }
                }
              }
            }
          ],
          states: {
            hover: {
              filter: {
                type: 'none'
              }
            },
            active: {
              filter: {
                type: 'none'
              }
            }
          }
        };
      if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
        const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
        totalRevenueChart.render();
      }

      const incomeChartEl = document.querySelector('#incomeChart'),
        incomeChartConfig = {
          series: [{
            data: [24, 21, 30, 22, 42, 26, 35, 0]
          }],
          chart: {
            height: 215,
            parentHeightOffset: 0,
            parentWidthOffset: 0,
            toolbar: {
              show: false
            },
            type: 'area'
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 2,
            curve: 'smooth'
          },
          legend: {
            show: false
          },
          markers: {
            size: 6,
            colors: 'transparent',
            strokeColors: 'transparent',
            strokeWidth: 4,
            discrete: [{
              fillColor: config.colors.white,
              seriesIndex: 0,
              dataPointIndex: 7,
              strokeColor: config.colors.primary,
              strokeWidth: 2,
              size: 6,
              radius: 8
            }],
            hover: {
              size: 7
            }
          },
          colors: [config.colors.primary],
          fill: {
            type: 'gradient',
            gradient: {
              shade: shadeColor,
              shadeIntensity: 0.6,
              opacityFrom: 0.5,
              opacityTo: 0.25,
              stops: [0, 95, 100]
            }
          },
          grid: {
            borderColor: borderColor,
            strokeDashArray: 3,
            padding: {
              top: -20,
              bottom: -8,
              left: -10,
              right: 8
            }
          },
          xaxis: {
            categories: [ 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            },
            labels: {
              show: true,
              style: {
                fontSize: '13px',
                colors: axisColor
              }
            }
          },
          yaxis: {
            labels: {
              show: false
            },
            min: 10,
            max: 50,
            tickAmount: 4
          }
        };
      if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
        const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
        incomeChart.render();
      }

      // Expenses Mini Chart - Radial Chart
      // --------------------------------------------------------------------

    })();
  </script>
@endpush

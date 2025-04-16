$(document).ready(function () {
    $('header .hamburger-wrap svg').click(function () {
        $('.sidenav').toggleClass('open');
        $('body').toggleClass('noscroll')
    });
    $('.table .circle-wrap').on('click', function(){
        $(this).closest('.row').find('.actions-wrap').first().toggle();
    });
    $('.sidenav .nav li.has-sublinks').on('click', function() {
        $(this).closest('li').find('.sub-links').slideToggle();
    });
    $('.landing-page-header .hamburger-wrap').click(function(){
        $('.landing-page-header .inner').toggleClass('open');
        $('.landing-page-header').toggleClass('active');
        $('body').toggleClass('noscroll');
    });



    /*Votes and Insights Graph Start*/
    const datasets = {
        today: {
          labels: ['Item A', 'Item B', 'Item C'],
          yes: [200, 300, 250],
          no: [150, 120, 180]
        },
        weekly: {
          labels: ['Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum'],
          yes: [900, 600, 1300, 1400, 2700, 1100, 900],
          no: [1200, 900, 1500, 2200, 1100, 2100, 2000]
        },
        monthly: {
          labels: ['Item X', 'Item Y', 'Item Z'],
          yes: [5000, 3000, 4000],
          no: [2500, 2800, 1900]
        }
      };
  
      let voteChart;
  
      function renderChart(period) {
        const dataSet = datasets[period];
  
        const data = {
          labels: dataSet.labels,
          datasets: [
            {
              label: 'Yes',
              data: dataSet.yes,
              backgroundColor: '#003b1b'
            },
            {
              label: 'No',
              data: dataSet.no,
              backgroundColor: '#ccff66'
            }
          ]
        };
  
        const config = {
          type: 'bar',
          data: data,
          options: {
            responsive: true,
            plugins: {
              tooltip: {
                callbacks: {
                  label: function(context) {
                    return ` ${context.dataset.label}: ${context.raw}`;
                  },
                  afterLabel: function(context) {
                    return 'Last week: 241\nThis week: 274';
                  }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 400
                }
              }
            }
          }
        };
  
        if (voteChart) {
          voteChart.destroy();
        }
  
        const ctx = document.getElementById('voteChart').getContext('2d');
        voteChart = new Chart(ctx, config);
      }
  
      $(document).ready(function () {
        renderChart('today'); // initial chart
  
        $('.tab').on('click', function () {
          $('.tab').removeClass('active');
          $(this).addClass('active');
  
          const period = $(this).data('period');
          renderChart(period);
        });
      });
      /*Votes and graph end*/ 
});
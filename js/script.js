$(document).ready(function () {
    $('header .hamburger-wrap svg').click(function () {
        $('.sidenav').toggleClass('open');
        $('body').toggleClass('noscroll')
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
          labels: ['Item X', 'Item Y', 'Item Z', 'Item N'],
          yes: [5000, 3000, 4000, 500],
          no: [2500, 2800, 1900, 1000]
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
              backgroundColor: '#102E16',
            },
            {
              label: 'No',
              data: dataSet.no,
              backgroundColor: '#E7FFB3'
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
                backgroundColor: '#C6D6B1',
                titleColor: '#134027',
                bodyColor: '#555',
                titleFont: {
                  size: 10,
                  weight: 'lighter'
                },
                callbacks: {
                  label: function(context) {
                    return ` ${context.dataset.label}: ${context.raw}`;
                  },
                  afterLabel: function(context) {
                    return 'Last week: 241\  week: 274';
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

      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('togglePassword');
      const iconSvgPath = toggleIcon.querySelector('path');
  
      const eye = "M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8M12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10 10 0 0 1 12 5.5";
      const eyeOff = "M2.22 2.22a.75.75 0 0 0-.073.976l.073.084l4.034 4.035a10 10 0 0 0-3.955 5.75a.75.75 0 0 0 1.455.364a8.5 8.5 0 0 1 3.58-5.034l1.81 1.81A4 4 0 0 0 14.8 15.86l5.919 5.92a.75.75 0 0 0 1.133-.977l-.073-.084l-6.113-6.114l.001-.002l-6.95-6.946l.002-.002l-1.133-1.13L3.28 2.22a.75.75 0 0 0-1.06 0M12 5.5c-1 0-1.97.148-2.889.425l1.237 1.236a8.503 8.503 0 0 1 9.899 6.272a.75.75 0 0 0 1.455-.363A10 10 0 0 0 12 5.5m.195 3.51l3.801 3.8a4.003 4.003 0 0 0-3.801-3.8";

      toggleIcon.addEventListener('click', function () {
          const isPassword = passwordInput.type === 'password';
          passwordInput.type = isPassword ? 'text' : 'password';
          iconSvgPath.setAttribute('d', isPassword ? eyeOff : eye);
      });
});
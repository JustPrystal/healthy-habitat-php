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
  
      const eye = "M11.5 18c4 0 7.46-2.22 9.24-5.5C18.96 9.22 15.5 7 11.5 7s-7.46 2.22-9.24 5.5C4.04 15.78 7.5 18 11.5 18m0-12c4.56 0 8.5 2.65 10.36 6.5C20 16.35 16.06 19 11.5 19S3 16.35 1.14 12.5C3 8.65 6.94 6 11.5 6m0 2C14 8 16 10 16 12.5S14 17 11.5 17S7 15 7 12.5S9 8 11.5 8m0 1A3.5 3.5 0 0 0 8 12.5a3.5 3.5 0 0 0 3.5 3.5a3.5 3.5 0 0 0 3.5-3.5A3.5 3.5 0 0 0 11.5 9";
      const eyeOff = "M2 4.27L3.28 3 21 20.72 19.73 22l-2.14-2.14C15.61 20.57 13.62 21 11.5 21c-4.56 0-8.5-2.65-10.36-6.5a10.06 10.06 0 0 1 2.33-3.24L2 4.27M11.5 5c4.56 0 8.5 2.65 10.36 6.5a10.057 10.057 0 0 1-2.89 3.49L15.17 12c.22-.5.33-1.03.33-1.5A3.5 3.5 0 0 0 12 7c-.47 0-.93.11-1.33.3L8.2 4.83C9.2 4.58 10.32 5 11.5 5m0 12a3.5 3.5 0 0 0 3.27-2.17l-1.7-1.7A1.5 1.5 0 0 1 11.5 15a1.5 1.5 0 0 1-1.5-1.5c0-.28.08-.54.22-.76l-1.6-1.6c-.38.55-.62 1.22-.62 1.86a3.5 3.5 0 0 0 3.5 3.5Z";
  
      toggleIcon.addEventListener('click', function () {
          const isPassword = passwordInput.type === 'password';
          passwordInput.type = isPassword ? 'text' : 'password';
          iconSvgPath.setAttribute('d', isPassword ? eyeOff : eye);
      });
});
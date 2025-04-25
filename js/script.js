$(document).ready(function () {
    $('header .hamburger-wrap svg').click(function () {
        $('.sidenav').toggleClass('open');
        $('body').toggleClass('noscroll')
      });
      $('.sidenav .nav li.user-drop').on('click', function() {
        $(this).closest('li').find('.sub-links').slideToggle();
        $('.has-sublinks .dropdown-icon-user').toggleClass('rotate-user');
    });


    $('.sidenav .nav li.product-drop').on('click', function() {
      $(this).closest('li').find('.sub-links').slideToggle();
      $('.has-sublinks .dropdown-icon-product').toggleClass('rotate-product');
  });

    $('.sidenav .nav li.listing-drop').on('click', function() {
      $(this).closest('li').find('.sub-links').slideToggle();
      $('.has-sublinks .dropdown-icon-listing').toggleClass('rotate-listing');
  });

    $('.landing-page-header .hamburger-wrap').click(function(){
        $('.landing-page-header .inner').toggleClass('open');
        $('.landing-page-header').toggleClass('active');
        $('body').toggleClass('noscroll');
    });



    /*Votes and Insights Graph Start*/
    let voteChart;

    function fetchChartData() {
      fetch('./Blocks/sme/get_votes.php')
        .then(res => res.json())
        .then(data => {
          const labels = data.map(item => item.name);
          const yes = data.map(item => parseInt(item.upvotes));
          const no = data.map(item => parseInt(item.downvotes));
          renderChart(labels, yes, no);
        })
      .catch(error => console.error('Error fetching Votes data:', error));
    }
    
    function renderChart(labels, yesData, noData) {
      const data = {
        labels: labels,
        datasets: [
          {
            label: 'Yes',
            data: yesData,
            backgroundColor: '#102E16',
          },
          {
            label: 'No',
            data: noData,
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
                  return ''; // Customize or leave empty
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 100 // adjust as needed
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
      fetchChartData(); // fetch once on page load
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
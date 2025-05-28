(function ($) {
  "use strict";

  $(document).ready(function () {

    var swiper = new Swiper(".testimonial-swiper", {
      slidesPerView: 1,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    // product single page
    var thumb_slider = new Swiper(".product-thumbnail-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 8,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });

    var large_slider = new Swiper(".product-large-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 10,
      effect: 'fade',
      thumbs: {
        swiper: thumb_slider,
      },
    });

    $('.navbar').on('click', '.search-toggle', function (e) {
      var selector = $(this).data('selector');

      $(selector).toggleClass('show').find('.search-input').focus();
      $(this).toggleClass('active');

      e.preventDefault();
    });

    window.addEventListener("load", (event) => {
      //isotope
      $('.isotope-container').isotope({
        // options
        itemSelector: '.item',
        layoutMode: 'masonry',
      });

      // Initialize Isotope
      var $container = $('.isotope-container').isotope({
        // options
        itemSelector: '.item',
        layoutMode: 'masonry',
      });

      $(document).ready(function () {
        //active button
        $('.filter-button').click(function () {
          $('.filter-button').removeClass('active');
          $(this).addClass('active');
        });
      });

      // Filter items on button click
      $('.filter-button').click(function () {
        var filterValue = $(this).attr('data-filter');
        if (filterValue === '*') {
          // Show all items
          $container.isotope({ filter: '*' });
        } else {
          // Show filtered items
          $container.isotope({ filter: filterValue });
        }
      });

    });

    // Header scroll effect
    document.addEventListener("scroll", function() {
      const header = document.getElementById("myHeader");
      if (window.scrollY > 50) {
        header.classList.add("bg-scrolled");
      } else {
        header.classList.remove("bg-scrolled");
      }
    });

    // Location modal logic
    document.addEventListener('DOMContentLoaded', function() {
      // Location Selection Logic
      const locationModal = document.getElementById('locationModal');
      if (!locationModal) return;
      const selectedLocation = document.getElementById('selectedLocation');
      const steps = document.querySelectorAll('.location-step');
      const backButtons = document.querySelectorAll('.back-btn');
      const districtsList = document.getElementById('districtsList');
      const neighborhoodsList = document.getElementById('neighborhoodsList');
      const getCurrentLocationBtn = document.getElementById('getCurrentLocation');

      // Get location data from backend
      const locationDataEl = document.getElementById('locationData');
      if (!locationDataEl) return;
      const locationData = JSON.parse(locationDataEl.dataset.locations);
      const userLocationData = locationDataEl.dataset.userLocation;

      // Set initial location from session if available
      if (userLocationData && userLocationData !== 'null') {
        const userLocation = JSON.parse(userLocationData);
        const distanceKm = userLocation.distance.toFixed(2);
        selectedLocation.textContent = `${userLocation.name} (${distanceKm}km)`;
      }

      // Get current location
      getCurrentLocationBtn.addEventListener('click', function() {
        if (!navigator.geolocation) {
          alert('Geolocation is not supported by your browser');
          return;
        }

        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Getting location...';

        navigator.geolocation.getCurrentPosition(
          async function(position) {
            const { latitude, longitude } = position.coords;
            // Find nearest neighborhood
            let nearestNeighborhood = null;
            let shortestDistance = Infinity;
            // Function to calculate distance between two points using Haversine formula
            function calculateDistance(lat1, lon1, lat2, lon2) {
              const R = 6371; // Earth's radius in kilometers
              const dLat = (lat2 - lat1) * Math.PI / 180;
              const dLon = (lon2 - lon1) * Math.PI / 180;
              const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
              const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
              return R * c;
            }
            // Iterate through all locations to find nearest neighborhood
            for (const [emirate, districts] of Object.entries(locationData)) {
              for (const [district, neighborhoods] of Object.entries(districts)) {
                for (const neighborhood of neighborhoods) {
                  if (neighborhood.lat && neighborhood.lng) {
                    const distance = calculateDistance(
                      latitude,
                      longitude,
                      parseFloat(neighborhood.lat),
                      parseFloat(neighborhood.lng)
                    );
                    if (distance < shortestDistance) {
                      shortestDistance = distance;
                      nearestNeighborhood = {
                        name: neighborhood.name,
                        emirate: emirate,
                        district: district,
                        distance: distance
                      };
                    }
                  }
                }
              }
            }
            if (nearestNeighborhood) {
              // Format distance to 2 decimal places
              const distanceKm = nearestNeighborhood.distance.toFixed(2);
              selectedLocation.textContent = `${nearestNeighborhood.name} (${distanceKm}km)`;
              // Save location to session via AJAX
              try {
                const response = await fetch('/location/save', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                  },
                  body: JSON.stringify(nearestNeighborhood)
                });
                if (!response.ok) {
                  throw new Error('Failed to save location');
                }
              } catch (error) {
                console.error('Error saving location:', error);
              }
              locationModal.querySelector('.btn-close').click();
            } else {
              alert('Could not find nearby neighborhoods. Please select manually.');
            }
            getCurrentLocationBtn.disabled = false;
            getCurrentLocationBtn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Use My Current Location';
          },
          function(error) {
            console.error('Error getting location:', error);
            alert('Error getting your location. Please select manually.');
            getCurrentLocationBtn.disabled = false;
            getCurrentLocationBtn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Use My Current Location';
          }
        );
      });

      // Emirate selection
      document.querySelectorAll('.emirate-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const emirate = this.dataset.emirate;
          showDistricts(emirate);
          steps[0].classList.add('d-none');
          steps[1].classList.remove('d-none');
        });
      });

      // Back button functionality
      backButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          const currentStep = this.closest('.location-step');
          const prevStep = currentStep.previousElementSibling;
          currentStep.classList.add('d-none');
          prevStep.classList.remove('d-none');
        });
      });

      // Show districts for selected emirate
      function showDistricts(emirate) {
        districtsList.innerHTML = '';
        if (locationData[emirate]) {
          Object.keys(locationData[emirate]).forEach(district => {
            const colDiv = document.createElement('div');
            colDiv.className = 'col-md-4';
            const btn = document.createElement('button');
            btn.className = 'btn btn-outline-primary w-100 district-btn';
            btn.textContent = district;
            btn.dataset.district = district;
            btn.dataset.emirate = emirate;
            btn.addEventListener('click', function() {
              showNeighborhoods(this.dataset.emirate, this.dataset.district);
              steps[1].classList.add('d-none');
              steps[2].classList.remove('d-none');
            });
            colDiv.appendChild(btn);
            districtsList.appendChild(colDiv);
          });
        }
      }

      // Show neighborhoods for selected district
      function showNeighborhoods(emirate, district) {
        neighborhoodsList.innerHTML = '';
        if (locationData[emirate] && locationData[emirate][district]) {
          locationData[emirate][district].forEach(neighborhood => {
            const colDiv = document.createElement('div');
            colDiv.className = 'col-md-4';
            const btn = document.createElement('button');
            btn.className = 'btn btn-outline-primary w-100 neighborhood-btn';
            btn.textContent = neighborhood.name || neighborhood;
            btn.dataset.neighborhood = neighborhood.name || neighborhood;
            btn.dataset.district = district;
            btn.dataset.emirate = emirate;
            btn.addEventListener('click', async function() {
              const location = {
                name: this.dataset.neighborhood,
                emirate: this.dataset.emirate,
                district: this.dataset.district,
                distance: 0 // Since it's manually selected, we'll set distance to 0
              };
              selectedLocation.textContent = location.name;
              // Save location to session via AJAX
              try {
                const response = await fetch('/location/save', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                  },
                  body: JSON.stringify(location)
                });
                if (!response.ok) {
                  throw new Error('Failed to save location');
                }
              } catch (error) {
                console.error('Error saving location:', error);
              }
              locationModal.querySelector('.btn-close').click();
            });
            colDiv.appendChild(btn);
            neighborhoodsList.appendChild(colDiv);
          });
        }
      }

      // Reset modal when closed
      locationModal.addEventListener('hidden.bs.modal', function() {
        steps.forEach((step, index) => {
          if (index === 0) {
            step.classList.remove('d-none');
          } else {
            step.classList.add('d-none');
          }
        });
      });
    });

  }); // End of a document


})(jQuery); 
docReady(function () {
  var controller = null;

  if (document.querySelector('.autocomplete .search')) {
    document.querySelector('.autocomplete .search').addEventListener('input', event => {
      if(controller){
        controller.abort();
      }

      controller = new AbortController();
      var signal = controller.signal;
      var locale = event.target.dataset.locale;
      var res = fetch("/" + locale +"/wp-json/apovoice/v1/pharmacies-fuzzy-search?s=" + event.target.value, {
        method: 'get',
        signal: signal,
      }).then(response => response.json())
        .then(data => {
          let code = "";
          console.log(data)
          data.results.forEach(item => {
            code += '<div class="item">'+item+'</div>'
          })
          document.querySelector('.autocomplete .results').innerHTML = code;
          document.querySelectorAll('.autocomplete .results .item').forEach(item => item.addEventListener('click', event => {
            setAddressData(event.target.innerHTML, locale);
            document.querySelector('.autocomplete').focus();
          }));
        }
      ).catch(error => console.log(error));
    });
  }

  function setAddressData(data, locale){
    console.log("data");
    console.log(data);
    let result = null;
    try {
      const [name, streetWithNumber, zip, city] = data.split(',').map(row => row.trim());
      const match = streetWithNumber.match(/\d/);
      const street = streetWithNumber.substr(0, match.index).trim();
      const number = streetWithNumber.substr(match.index).trim();

      result = [
        [
          {
            "title": "pharmacyName",
            "value": name
          },
          {
            "title": "pharmacyCountry",
            "value": "germany"
          },
          {
            "title": "pharmacyStreet",
            "value": street
          },
          {
            "title": "pharmacyStreetNo",
            "value": number
          },
          {
            "title": "pharmacyZipCode",
            "value": zip
          },
          {
            "title": "pharmacyCity",
            "value": city
          }
        ]
      ];
    } catch (error) {
      console.error(error);
    }
    document.querySelector('.autocomplete .selected').value = JSON.stringify(result);
  }

  document.querySelector('.exportFilteredUsers').addEventListener('click', event => {
    event.stopPropagation();
    event.preventDefault();

    var form = document.querySelector('.filterForm');
    form.action = event.target.href;
    form.submit();

    form.action = "";
  });

  var state = [];
  var multiselects = document.querySelectorAll('.multiselect');

  multiselects.forEach((select, index) => {
    var active = select.querySelector('input.active');
    var inactive = select.querySelector('input.inactive');
    state[index] = {select: select, active: [], inactive: []};

    if(active.value.trim().length > 0)
      state[index].active = active.value.trim().split(",");
    if(inactive.value.trim().length > 0)
      state[index].inactive = inactive.value.trim().split(",");

    select.querySelectorAll('.option').forEach(option => {
      if(state[index].active.includes(option.dataset.id))
        option.classList.add('active');
      if(state[index].inactive.includes(option.dataset.id))
        option.classList.add('inactive');

      option.addEventListener('click', (e) => {
        if(e.currentTarget.classList.contains('active')){
          e.currentTarget.classList.remove('active');
          e.currentTarget.classList.add('inactive');
          state[index].inactive.push(e.currentTarget.dataset.id);
          state[index].active = state[index].active.filter(item => item !== e.currentTarget.dataset.id);
        }
        else if(e.currentTarget.classList.contains('inactive')){
          e.currentTarget.classList.remove('inactive');
          state[index].inactive = state[index].inactive.filter(item => item !== e.currentTarget.dataset.id);
        }
        else{
          e.currentTarget.classList.add('active');
          state[index].active.push(e.currentTarget.dataset.id);
        }
        active.value = state[index].active.join(',');
        inactive.value = state[index].inactive.join(',');
      })
    })
    
  });

});






function docReady(fn) {
  // see if DOM is already available
  if (document.readyState === "complete" || document.readyState === "interactive") {
      // call on next available tick
      setTimeout(fn, 1);
  } else {
      document.addEventListener("DOMContentLoaded", fn);
  }
}    
(function (document){

  document.addEventListener('DOMContentLoaded',
    () => {

      if (typeof(window.mqSettings?.modernquery_domain_name) == 'undefined') {
        console.log('ModernQuery: No domain name specified. Go to the plugin settings and specify a domain name');
        return; 
      }
      
      const domainName = window.mqSettings.modernquery_domain_name;
      const inputSelector = window.mqSettings?.modernquery_search_input_selector ?? 'input[name="s"][type="search"]';
      const endpoint = 'https://api.modernquery.io/document/autocomplete';

      const inputs = document.querySelectorAll(
        inputSelector
      );

      //
      // Disable the browser default autocomplete
      //
      if (inputs.length > 0) {
        inputs.forEach(
          (curInput) => {
            curInput.setAttribute('autocomplete', 'off');
          }
        )
      }

      console.log('about to configure autocomplete library', inputSelector);

      const autoCompleteJS = new autoComplete(
        {
          name: 'mq_autocomplete',
          submit: true,
          selector: inputSelector,
          placeHolder: "Search",
          data: {
            src: async (query) => {
              try {
                const params = {
                  'keywords': query,
                  'domain': domainName
                };
                const queryString = new URLSearchParams(params).toString()
                const requestUrl = `${endpoint}?${queryString}`;
                // Fetch Data from external Source
                const source = await fetch(requestUrl);
                const data = await source.json();

                console.log('data returned from autocomplete', data);

                return data.suggestions;
              } 
              catch (error) {
                  return error;
              }
            },
            keys: ['title']
          },
          events: {
            input: {
              focus() {
                console.log('search focus');
                if (autoCompleteJS.input.value.length) autoCompleteJS.start();
              },
              selection(event) {
                const feedback = event.detail;

                console.log(feedback);

                // Prepare User's Selected Value
                const selection = feedback.selection.value;
                
                if (typeof(selection.url) != 'undefined') {
                  window.location.href = selection.url;
                }
                else {
                  // Replace Input value with the selected value
                  autoCompleteJS.input.value = selection;
                  
                  const form = autoCompleteJS.input.closest('form');



                  form.submit();
                }
              },
            },
          },
          //data: {
          //    src: ["Sauce - Thousand Island", "Wild Boar - Tenderloin", "Goat - Whole Cut"]
          //},
          resultItem: {
              highlight: true,
          }
        }
      );
    }
    
  )

})(document);
(function (document){

  document.addEventListener('DOMContentLoaded',
    () => {

      (async () => {
        if (typeof(window.mqSettings?.modernquery_domain_name) == 'undefined') {
          console.log('ModernQuery: No domain name specified. Go to the plugin settings and specify a domain name');
        }
        
        const domainName = window.mqSettings.modernquery_domain_name;
        const inputSelector = window.mqSettings?.modernquery_search_input_selector ?? 'input[name="s"]';
        const endpoint = 'https://api.modernquery.io/document/chat';

        const submitButtons = document.querySelectorAll('.mq-chat-form-submit-button');

        console.log('submitbuttons', submitButtons);

        if (submitButtons.length > 0) {
          submitButtons.forEach(
            (button) => {
              button.addEventListener('click',
                (event) => {
                  console.log('event', event);
                  (async (event) => {

                    const mq_id = event.target.getAttribute('data-mq-id');
                    
                    if (!mq_id) {
                      console.log('ModernQuery: Submit button clicked with no mq-id data attribute set');
                      return;
                    }

                    const resultsField = document.querySelector(`.mq-chat-results[data-mq-id="${mq_id}"]`);
                    const inputField = document.querySelector(`.mq-chat-prompt[data-mq-id="${mq_id}"]`);

                    const prompt = inputField.value;
                    console.log('prompt', prompt);
                    if (prompt) {
                      
                      event.target.innerHTML = "Loading...";
                      const endpoint = 'https://api.modernquery.io/document/chat';

                      const params = {
                        'prompt': prompt,
                        'domain': domainName
                      };
                      
                      const queryString = new URLSearchParams(params).toString()
                      const requestUrl = `${endpoint}?${queryString}`;
                      // Fetch Data from external Source
                      const source = await fetch(requestUrl);
                      const data = await source.json();      

                      console.log('data', data);

                      if (typeof(data.text) != 'undefined') {
                        resultsField.innerHTML = data.text;
                      }

                      event.target.innerHTML = "Submit";
                    }            
                  })(event);

                }
              );
            }
          )
        }

        // const params = {
        //   'prompt': query,
        //   'domain': domainName
        // };
        // const queryString = new URLSearchParams(params).toString()
        // const requestUrl = `${endpoint}?${queryString}`;
        // // Fetch Data from external Source
        // const source = await fetch(requestUrl);
        // const data = await source.json();

        // console.log('data returned from autocomplete', data);
      })();

    }
    
  )

})(document);

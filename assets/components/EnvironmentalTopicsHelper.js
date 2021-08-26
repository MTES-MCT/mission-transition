import React, {useState, useEffect, useCallback} from 'react'

const EnvironmentalTopicsHelper = () => {
    const [selectedTopic, setSelectedTopic] = useState(null);
    const selectInput = document.querySelector('#search_form_environmentalTopic');
    const onSelectChange = useCallback(e => {
        console.log(e.target.value);
        setSelectedTopic(e.target.value);
    }, []);

    const getHelperText = (value) => {
        const mapping = {
            'Conservation et restauration des écosystèmes' : '',
            'Économie circulaire' : '',
            'Efficacité énergétique' : '',
            'Production et distribution d\'énergie' : '',
        }
    };

    useEffect(() => {
        selectInput.addEventListener('onChange', onSelectChange);
    }, []);

    return (
      <div>
          {/*<h4>Exemples de projets:</h4>*/}
          <p>{selectedTopic}</p>
      </div>
    );
};

export default EnvironmentalTopicsHelper
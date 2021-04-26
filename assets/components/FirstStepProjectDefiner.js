import React, { useState } from 'react';
import ExtendedSelect from './ExtendedSelect';

const FirstStepProjectDefiner = ({ optgroups }) => {
    const [selectedOption, setSelectedOption] = useState(null);
    let environmentalActionSelect = document.querySelector('#search_form_environmentalAction');
    const onSelect = (option) => {
        if (option === selectedOption) {
            setSelectedOption(null);
        } else {
            setSelectedOption(option);
            environmentalActionSelect.value = option.name;
        }
    };
    let isSelected = selectedOption !== null;
    return (
        <>
            <div className="rf-grid-row rf-px-md-12w rf-pt-6w rf-pt-md-12w">
                <div className="rf-col-12 rf-col-md-6">
                    <h3 className="color-navy">Mon objectif</h3>
                    <p className="subtitle rf-pb-1w">Sélectionnez 1 objectif dans la liste suivante</p>
                </div>
                <div className="rf-col-12 rf-col-md-6 submit-project">
                    <button type="submit" className="rf-btn" disabled={!isSelected}>
                        CONSULTER LES RÉSULTATS
                    </button>
                </div>
            </div>
            <ExtendedSelect optgroups={optgroups} onSelect={onSelect} selectedOption={selectedOption} />
        </>
    );
};

export default FirstStepProjectDefiner;

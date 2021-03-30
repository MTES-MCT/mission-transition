import React, { useState } from 'react';
import { useCombobox } from 'downshift';
import { fetchCompanyBySiren, fetchCompanyBySiret, fetchCompaniesByText } from '../api';

const CompanyDataAutocomplete = () => {
    const menuStyles = {
        maxHeight: 80,
        maxWidth: 300,
        overflowY: 'scroll',
        backgroundColor: '#eee',
        padding: 0,
        listStyle: 'none',
        position: 'relative',
    };
    const comboboxStyles = { display: 'inline-block', marginLeft: '5px' };
    const [inputItems, setInputItems] = useState([]);

    const onInputValueChange = ({ inputValue }) => {
        //SIRET
        if (inputValue.match('^[0-9]{14}$')) {
            fetchCompanyBySiret(inputValue).then((data) => {
                if (!data['etablissement']) {
                    setInputItems(['non trouvé']);
                } else {
                    data['etablissement']['_name'] = data['etablissement']['unite_legale']['denomination'];
                    setInputItems([data['etablissement']]);
                }
            });
            return;
        }

        //SIREN
        if (inputValue.match('^[0-9]{9}$')) {
            fetchCompanyBySiren(inputValue).then((data) => {
                if (!data['unite_legale']) {
                    setInputItems(['non trouvé']);
                } else {
                    //We add `_name` key to access company name easily regardless of data structure
                    data['unite_legale']['_name'] = data['unite_legale']['denomination'];
                    setInputItems([data['unite_legale']]);
                }
            });
            return;
        }

        //Text
        if (inputValue.match('^.{2,}$')) {
            fetchCompaniesByText(inputValue).then((data) => {
                if (!data['etablissement']) {
                    setInputItems(['non trouvé']);
                } else {
                    setInputItems(
                        data['etablissement'].map((company) => {
                            company['_name'] = company['nom_raison_sociale'];
                            return company;
                        })
                    );
                }
            });
        }
    };
    const itemToString = (item) => item['_name'];

    const onSelectedItemChange = (item) => {
        let regionSelect = document.querySelector('#search_form_region');
        item = item.selectedItem;
        for (let i = 0, length = regionSelect.length; i < length; i++) {
            if (regionSelect.options[i].text === item['libelle_region']) {
                regionSelect.selectedIndex = i;
                break;
            }
        }
    };

    const {
        isOpen,
        selectedItem,
        getToggleButtonProps,
        getLabelProps,
        getMenuProps,
        getInputProps,
        getComboboxProps,
        highlightedIndex,
        getItemProps,
    } = useCombobox({
        items: inputItems,
        itemToString,
        onInputValueChange: onInputValueChange,
        onSelectedItemChange: onSelectedItemChange,
    });

    return (
        <>
            <label {...getLabelProps()}>Choose an element:</label>
            <div style={comboboxStyles} {...getComboboxProps()}>
                <input {...getInputProps()} />
                <button type="button" {...getToggleButtonProps()} aria-label={'toggle menu'}>
                    &#8595;
                </button>
            </div>
            <ul {...getMenuProps()} style={menuStyles}>
                {isOpen &&
                    inputItems.map((item, index) => (
                        <li
                            style={highlightedIndex === index ? { backgroundColor: '#bde4ff' } : {}}
                            key={`${item}${index}`}
                            {...getItemProps({ item, index })}>
                            {typeof item === 'object' && item !== null ? itemToString(item) : item}
                        </li>
                    ))}
            </ul>
        </>
    );
};

export default CompanyDataAutocomplete;

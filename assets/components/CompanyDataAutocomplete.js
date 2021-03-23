import React, { useState } from 'react';
import { useCombobox } from 'downshift';
import { fetchCompanyBySiren, fetchCompanyBySiret, fetchCompaniesByText } from '../api';

const CompanyDataAutocomplete = () => {
    const [items, setItems] = useState();
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
                console.log(data);
                if (!data['etablissement']) {
                    setInputItems(['non trouvé']);
                } else {
                    setInputItems([data['etablissement']['unite_legale']['denomination']]);
                }
            });
            return;
        }

        //SIREN
        if (inputValue.match('^[0-9]{9}$')) {
            fetchCompanyBySiren(inputValue).then((data) => {
                console.log(data);
                if (!data['unite_legale']) {
                    setInputItems(['non trouvé']);
                } else {
                    setInputItems([data['unite_legale']['denomination']]);
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
                    console.log(data);
                    setInputItems(data['etablissement']);
                }
            });
        }
    };
    const itemToString = (item) => item['nom_raison_sociale'];

    const onSelectedItemChange = (item) => {};

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
                            {itemToString(item)}
                        </li>
                    ))}
            </ul>
        </>
    );
};

export default CompanyDataAutocomplete;

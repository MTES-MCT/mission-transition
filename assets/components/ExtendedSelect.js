import React, { useState } from 'react';
import '../styles/components/extended_select.scss';

const ExtendedSelect = ({ optgroups, onSelect, selectedOption }) => {
    optgroups = Object.entries(optgroups);
    const half = Math.floor(optgroups.length / 2);
    const otherHalf = optgroups.length - half;
    const leftGroup = optgroups.splice(0, half);
    const rightGroup = optgroups.splice(-otherHalf);
    const renderOptGroups = (group) => {
        return group.map(([optgroup, options], index) => {
            return (
                <div className="optgroup-wrapper">
                    <p className="subtitle highlighted">{optgroup}</p>
                    {options.map((option) => {
                        let isSelected = selectedOption && selectedOption === option;
                        return (
                            <span className={isSelected ? 'selected tag' : 'tag'} onClick={() => onSelect(option)}>
                                {option.name}
                            </span>
                        );
                    })}
                </div>
            );
        });
    };

    return (
        <div className="extended-select">
            <div className="left">{renderOptGroups(leftGroup)}</div>
            <div className="right">{renderOptGroups(rightGroup)}</div>
        </div>
    );
};

export default ExtendedSelect;

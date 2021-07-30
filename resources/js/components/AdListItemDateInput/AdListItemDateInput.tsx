import * as React from "react";
import { adListItemDateInputConfig } from "./adListItemDateInputConfig";
import { TextField } from "@material-ui/core";
import * as moment from "moment";
import {useEffect} from "react";

type AdListItemDateSelectorProps = {
    dateStart?: String,
    dateEnd?: String,
    handleDateStartChange: (e) => void,
    handleDateEndChange: (e) => void
};

const AdListItemDateInput = (
    {
        dateStart,
        dateEnd,
        handleDateStartChange,
        handleDateEndChange
    }: AdListItemDateSelectorProps
) => {
    return (
        <div className="ad-list-item-date-selector">
            <div className="ad-list-item-date-selector-date-start">
                <TextField value={ moment(dateStart.toString()).format(adListItemDateInputConfig.dateFormat) }
                           id="ad-list-item-date-selector-date-start-input"
                           type="datetime-local"
                           onChange={ handleDateStartChange }
                           variant="outlined"
                           label={ adListItemDateInputConfig.labels.dateStartLabel }
                />
            </div>
            <div className="ad-list-item-date-selector-date-end">
                <TextField  value={ moment(dateEnd.toString()).format(adListItemDateInputConfig.dateFormat) }
                            id="ad-list-item-date-selector-date-end-input"
                            type="datetime-local"
                            onChange={ handleDateEndChange }
                            variant="outlined"
                            label={ adListItemDateInputConfig.labels.dateEndLabel }
                />
            </div>
        </div>
    );
};

export default AdListItemDateInput;

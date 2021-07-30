import * as React from "react";
import { TextField } from "@material-ui/core";
import { adListItemFormConfig } from "../AdListItemForm/adListItemFormConfig";

type AdListItemUsdInputProps = {
    usdDaily: String,
    usdTotal: String,
    handleUsdTotalChange: (e) => void
};

const AdListItemUsdInput = ({usdDaily, usdTotal, handleUsdTotalChange }: AdListItemUsdInputProps) => {
    return (
        <div className="ad-list-item-usd-input">
            <div className="ad-list-item-usd-input-usd-total-block">
                <TextField value={ usdTotal.toString() }
                           onChange={ handleUsdTotalChange }
                           label={ adListItemFormConfig.labels.usdTotalInput }
                           variant="outlined"
                />
            </div>
        </div>
    );
};

export default AdListItemUsdInput;

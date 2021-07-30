import * as React from "react";
import { adListItemConfig } from "./adListItemConfig";
import { Link } from "react-router-dom";
import { Button } from "@material-ui/core";
import {useCallback, useEffect} from "react";

type AdListItemProps = {
    id: Number,
    title: String,
    dateStart: Date,
    dateEnd: Date,
    usdDaily: Number,
    usdTotal: Number,
    images: String[],
    onShow: (id) => void
}

const AdListItem = ({ id, title, dateStart, dateEnd, usdDaily, usdTotal, onShow }: AdListItemProps) => {
    const handlePreviewShow = useCallback(() => onShow(id), [id]);

    return (
        <tr>
            <td>{ id }</td>
            <td>{ title }</td>
            <td>{ dateStart }</td>
            <td>{ dateEnd }</td>
            <td>{ usdDaily }</td>
            <td>{ usdTotal }</td>
            <td>
                <Button size="small" variant="contained" onClick={ handlePreviewShow }>
                    { adListItemConfig.buttonTitles.previewButtonTitle }
                </Button>
            </td>
            <td>
                <Link to={ "/edit/" + id }>
                    <Button size="small" variant="contained">
                        { adListItemConfig.buttonTitles.editButtonTitle }
                    </Button>
                </Link>
            </td>
        </tr>
    );
}

export default AdListItem;

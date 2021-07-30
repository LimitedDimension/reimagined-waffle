import * as React from "react";
import { useAppSelector } from "../../hooks";
import AdListItem from "../AdListItem/AdListItem";
import { useCallback, useEffect, useMemo, useState } from "react";
import { adListConfig } from "./AdListConfig";
import { adListItemsSelector} from "../../selectors/AdListSelectors";
import { fetchAdList } from "../../actions/AdListActions";
import { useDispatch } from "react-redux";
import { Link } from "react-router-dom";
import AdPreview from "../AdPreview/AdPreview";

const AdList = () => {
    const [currentItemId, setCurrentItemId] = useState<Number|null>(null);
    const items = useAppSelector(adListItemsSelector);
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(fetchAdList());
    },[]);

    const isPreviewModalOpen = useMemo(() => !!currentItemId, [currentItemId]);

    const handleOpenPreview = useCallback(id => {
        setCurrentItemId(id);
    }, [setCurrentItemId, currentItemId]);

    const handleClosePreview = useCallback(() => {
        setCurrentItemId(null);
    }, []);

    return (
        <div className="ad-list">
            <div className="ad-list-wrapper">
                <div className="ad-list-controls">
                    <Link to="/add">
                        <button>{ adListConfig.buttonTitles.addButtonTitle }</button>
                    </Link>
                </div>
                <table className="ad-list-content">
                    <thead>
                        <tr>
                            {
                                adListConfig.columnTitles.map(
                                    title => <th key={title}>{ title }</th>
                                )
                            }
                        </tr>
                    </thead>
                    <tbody>
                    {
                        items.map((item) =>
                            <AdListItem
                                key={ item.id.toString() }
                                id={ item.id }
                                title={ item.title }
                                dateStart={ item.dateStart }
                                dateEnd={ item.dateEnd }
                                usdDaily={ item.usdDaily }
                                usdTotal={ item.usdTotal }
                                images={ item.images }
                                onShow={ handleOpenPreview }
                            />
                        )
                    }
                    </tbody>
                </table>
            </div>
            {
                isPreviewModalOpen && (<AdPreview
                                         id={ currentItemId }
                                         handleClosePreview={ handleClosePreview }
                            />)
            }
        </div>
    );
}

export default AdList;

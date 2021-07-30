import axios from "axios";
import { ApiResponse } from "../types/ApiResponseType";
import { listError, listLoading, listReceived } from "../slices/AdListSlice";
import { AdListCreateRecordData, AdListUpdateRecordData } from "../types/AdListTypes";
import { appConfig } from "../appConfig";
import * as moment from "moment";

export const fetchAdList = () => dispatch => {
    dispatch(listLoading());

    return axios.get<ApiResponse>(appConfig.api.rootUrl + 'ad-list/items')
        .then((response) => {
            const res = response.data;

            if (res.success) {
                dispatch(listReceived(res.data));
            } else {
                dispatch(listError(res.message))
            }
        })
        .catch(error => dispatch(listError(error.message)));
}

export const sendAdListCreateRecord = (recordData: AdListCreateRecordData, history) => dispatch => {
    const formData = new FormData();
    const dateFormat = "YYYY-MM-DD HH:mm:ss";

    formData.append('title', recordData.title.toString());
    formData.append('dateStart', moment(recordData.dateStart.toString()).format(dateFormat));
    formData.append('dateEnd', moment(recordData.dateEnd.toString()).format(dateFormat));
    formData.append('usdTotal', recordData.usdTotal.toString());

    recordData.newImages.map((image, index) => formData.append('images[' + index + ']', image.data))

    return axios.post<ApiResponse>(
            appConfig.api.rootUrl + 'ad-list/items/add',
            formData,
        {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        )
        .then(response => {
            const res = response.data;

            if (res.success) {
                dispatch(listReceived(res.data));
            } else {
                dispatch(listError(res.message))
            }

            history.push("/");
        })
        .catch(error => dispatch(listError(error.message)));
};

export const sendAdListUpdateRecord = (recordData: AdListUpdateRecordData, history) => dispatch => {
    const formData = new FormData();

    formData.append('id', recordData.id.toString());
    formData.append('title', recordData.title.toString());
    formData.append('dateStart', recordData.dateStart.toString());
    formData.append('dateEnd', recordData.dateEnd.toString());
    formData.append('usdTotal', recordData.usdTotal.toString());

    recordData.newImages.map((image, index) => formData.append('newImages[' + index + ']', image.data))
    recordData.deletedImages.map((imageId, index) => formData.append('deletedImages[' + index + ']', imageId.toString()))

    return axios.post<ApiResponse>(
            appConfig.api.rootUrl + 'ad-list/items/edit',
            formData,
        {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        )
        .then(response => {
            const res = response.data;

            if (res.success) {
                dispatch(listReceived(res.data));
            } else {
                dispatch(listError(res.message))
            }

            history.push("/");
        })
        .catch(error => dispatch(listError(error.message)));
};

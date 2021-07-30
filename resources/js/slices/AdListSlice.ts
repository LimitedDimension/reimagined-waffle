import { createSlice } from "@reduxjs/toolkit";

const idleState = 'idle';
const pendingState = 'pending';
const dateFormat = 'YYYY-MM-DDThh:mm'

const initialState = {
    loading: idleState,
    items: [],
    error: ''
}

const adListSlice = createSlice({
    name: 'adListSlice',
    initialState,
    reducers: {
        listLoading(state) {
            if (state.loading === idleState) {
                state.loading = pendingState;
            }
        },
        listReceived(state, action) {
            if (state.loading === pendingState) {
                state.loading = idleState;
                state.items = action.payload;
            }
        },
        listError(state, action) {
            state.loading = idleState;
            state.error = action.payload;
        },
        addItem(state, action) {
            state.items.push(action.payload);
        }
    }
})

export default adListSlice.reducer;
export const { listLoading, listReceived, listError, addItem } = adListSlice.actions;

import * as React from "react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import { Provider } from "react-redux";
import store from "../../store";
import AdList from "../AdList/AdList";
import AdListItemForm from "../AdListItemForm/AdListItemForm";

const App = () => {
    return (
        <Provider store={store}>
            <Router>
                <Switch>
                    <Route key="add-record" exact path="/add" component={AdListItemForm} />
                    <Route path="/test/test">
                        Test
                    </Route>
                    <Route key="edit-record" exact path="/edit/:id" component={AdListItemForm} />
                    <Route path="/">
                        <AdList/>
                    </Route>
                </Switch>
            </Router>
        </Provider>
    );
};

export default App;

import "./AdminApplication.scss";
import "./Navigation/NavigationComponent";
import ViewEventHandler from "../../Core/View/ViewEventHandler";

export default class AdminApplication {
    public run()
    {
        const eventHandler = new ViewEventHandler();
        eventHandler.init(document.body);
    }
}

const app = new AdminApplication();
app.run();
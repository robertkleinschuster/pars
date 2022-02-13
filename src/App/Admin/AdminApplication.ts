import "./AdminApplication.scss";
import "./Navigation/NavigationComponent";
import ViewEventHandler from "../../Core/View/ViewEventHandler";
import OverviewComponent from "./Overview/OverviewComponent";

export default class AdminApplication {
    public run()
    {
        const eventHandler = new ViewEventHandler();
        eventHandler.init(document.body);
        const overview = new OverviewComponent();
    }
}

const app = new AdminApplication();
app.run();
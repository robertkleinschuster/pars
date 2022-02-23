import "./AdminApplication.scss";
import "../../Core/View/Navigation/NavigationComponent";
import ViewEventHandler from "../../Core/View/ViewEventHandler";
import OverviewComponent from "../../Core/View/Overview/OverviewComponent";
import Toolbar from "../../Core/View/Toolbar/Toolbar";
import Icon from "../../Core/View/Icon/Icon";
import Detail from "../../Core/View/Detail/Detail";
import Input from "../../Core/View/Input/Input";
import Editor from "../../Core/View/Editor/Editor";

export default class AdminApplication {
    public run()
    {
        document.querySelectorAll('.component').forEach( (component: HTMLElement) => {
            const eventHandler = new ViewEventHandler(new URL(document.location.href, document.baseURI), component);
            eventHandler.init();
        });

        const overview = new OverviewComponent();
        const detail = new Detail();
        const toolbar = new Toolbar();
        const icon = new Icon();
        const input = new Input();
        const editor = new Editor();
    }
}

const app = new AdminApplication();
app.run();

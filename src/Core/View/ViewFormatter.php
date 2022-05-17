<?php

namespace Pars\Core\View;

use Pars\Core\Util\Placeholder\PlaceholderHelper;

class ViewFormatter
{
    protected ViewComponent $component;

    /**
     * @param ViewComponent $component
     */
    public function __construct(ViewComponent $component)
    {
        $this->component = $component;
    }

    public function format(string $key, ViewModel $model)
    {
        $placeholders = PlaceholderHelper::findPlaceholderResolved($key);
        if (empty($placeholders)) {
            return $this->formatValue($model->get($key));
        } else {
            $data = [];
            foreach ($placeholders as $placeholder) {
                $data[$placeholder] = $this->formatValue($model->get($placeholder));
            }
            return PlaceholderHelper::replacePlaceholder($key, $data);
        }
    }

    protected function formatValue($value)
    {
        return $value;
    }
}

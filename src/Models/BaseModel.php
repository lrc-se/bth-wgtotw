<?php

namespace WGTOTW\Models;

/**
 * Base class for models.
 */
abstract class BaseModel implements ValidationInterface, \LRC\Repository\SoftManagedModelInterface
{
    use ValidationTrait;
    use \LRC\Repository\SoftManagedModelTrait;
}

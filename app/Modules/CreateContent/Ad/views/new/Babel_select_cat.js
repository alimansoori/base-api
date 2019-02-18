'use strict';

function _typeof(obj) {
    if (typeof Symbol === 'function' && typeof Symbol.iterator === 'symbol') {
        _typeof = function _typeof(obj) {
            return typeof obj;
        };
    } else {
        _typeof = function _typeof(obj) {
            return obj &&
            typeof Symbol === 'function' &&
            obj.constructor === Symbol &&
            obj !== Symbol.prototype
                ? 'symbol'
                : typeof obj;
        };
    }
    return _typeof(obj);
}

function _possibleConstructorReturn(self, call) {
    if (call && (_typeof(call) === 'object' || typeof call === 'function')) {
        return call;
    }
    return _assertThisInitialized(self);
}

function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf
        ? Object.getPrototypeOf
        : function _getPrototypeOf(o) {
            return o.__proto__ || Object.getPrototypeOf(o);
        };
    return _getPrototypeOf(o);
}

function _assertThisInitialized(self) {
    if (self === void 0) {
        throw new ReferenceError(
            "this hasn't been initialised - super() hasn't been called"
        );
    }
    return self;
}

function _inherits(subClass, superClass) {
    if (typeof superClass !== 'function' && superClass !== null) {
        throw new TypeError('Super expression must either be null or a function');
    }
    subClass.prototype = Object.create(superClass && superClass.prototype, {
        constructor: { value: subClass, writable: true, configurable: true }
    });
    if (superClass) _setPrototypeOf(subClass, superClass);
}

function _setPrototypeOf(o, p) {
    _setPrototypeOf =
        Object.setPrototypeOf ||
        function _setPrototypeOf(o, p) {
            o.__proto__ = p;
            return o;
        };
    return _setPrototypeOf(o, p);
}

function _instanceof(left, right) {
    if (
        right != null &&
        typeof Symbol !== 'undefined' &&
        right[Symbol.hasInstance]
    ) {
        return right[Symbol.hasInstance](left);
    } else {
        return left instanceof right;
    }
}

function _classCallCheck(instance, Constructor) {
    if (!_instanceof(instance, Constructor)) {
        throw new TypeError('Cannot call a class as a function');
    }
}

function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || false;
        descriptor.configurable = true;
        if ('value' in descriptor) descriptor.writable = true;
        Object.defineProperty(target, descriptor.key, descriptor);
    }
}

function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
}

function _defineProperty(obj, key, value) {
    if (key in obj) {
        Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
        });
    } else {
        obj[key] = value;
    }
    return obj;
}

// functions for classs
//
var link1 = 'https://ilyaidea.ir/build/index.php';
var link2 = 'https://ilyaidea.ir/api/ad/get/menu/category';

var IlyaMenu =
    /*#__PURE__*/
    (function() {
        function IlyaMenu() {
            var _this = this;

            var _name =
                arguments.length > 0 && arguments[0] !== undefined
                    ? arguments[0]
                    : null;

            var root = arguments.length > 1 ? arguments[1] : undefined;

            var _data =
                arguments.length > 2 && arguments[2] !== undefined
                    ? arguments[2]
                    : null;

            var _initId =
                arguments.length > 3 && arguments[3] !== undefined
                    ? arguments[3]
                    : null;

            _classCallCheck(this, IlyaMenu);

            _defineProperty(this, 'Init', function(map, initId) {
                _this.id = _this.appendNameToString(initId, _this.name); //  `${initId}${this.name}`;

                if (map) {
                    _this.data = _this.mapKeys(_this.data, map);
                } // as a init clearing all Html and adding tow div for header and content

                _this.root.innerHTML = '';

                _this.root.appendChild(
                    _this.creatorElem('div', ''.concat(_this.typeClass, '-select'))
                );

                _this.root.appendChild(
                    _this.creatorElem('div', ''.concat(_this.typeClass, '-content'))
                );

                _this.selectTag = _this.root.children[0];
                _this.contentTag = _this.root.children[1];

                _this.initSelect();

                _this.render(_this.id);
            });

            _defineProperty(this, 'initSelect', function() {
                _this.selectTag.innerHTML = 'select';
            });

            _defineProperty(this, 'mapKeys', function(data, keysMap) {
                return data.map(function(item) {
                    return (item = Object.keys(item).reduce(function(acc, key) {
                        return {
                            ...acc,
                            ..._defineProperty({}, keysMap[key] || key, item[key])
                        };
                    }, {}));
                });
            });

            _defineProperty(this, 'appendNameToProp', function(data, prop, name) {
                data.map(function(item) {
                    item[prop] = ''.concat(item[prop]).concat([name]);
                });
            });

            _defineProperty(this, 'appendNameToString', function(str, name) {
                return ''.concat(str).concat([name]);
            });

            _defineProperty(this, 'getId', function() {
                var id = (' ' + _this.id).slice(1);

                if (id[0] == 'n') return null;
                return id.slice(0, -_this.name.length);
            });

            _defineProperty(this, 'onChange', function() {});

            _defineProperty(this, 'onChangeBack', function() {});

            _defineProperty(this, 'onChangeHead', function() {});

            _defineProperty(this, 'onChangeChild', function() {});

            _defineProperty(this, 'onChangeEnd', function() {});

            _defineProperty(this, 'onChangeSelect', function() {});

            _defineProperty(this, 'handleChildEvent', function(item) {
                _this.onChange();
            });

            _defineProperty(this, 'handleBackEvent', function(item) {
                _this.onChange();
            });

            _defineProperty(this, 'handleHeadEvent', function(item) {
                _this.onChange();
            });

            _defineProperty(this, 'handleEndEvent', function(item) {
                _this.onChange();
            });

            _defineProperty(this, 'handleSelectEvent', function(item) {
                _this.onChange();
            });

            _defineProperty(this, 'contentLiMaker', function(item) {
                var type =
                    arguments.length > 1 && arguments[1] !== undefined
                        ? arguments[1]
                        : 'forward';

                var li = _this.creatorElem('li', null, item.id);

                switch (type) {
                    case 'back':
                        li.className = ''.concat(_this.typeClass, '-content__back');
                        li.innerHTML = '<i class="fal fa-caret-right icon-right"></i>';
                        li.innerHTML += item.title;
                        li.setAttribute('role', 'back');
                        break;

                    case 'head':
                        li.className = ''.concat(_this.typeClass, '-content__header');
                        li.innerHTML += item.title;
                        li.setAttribute('role', 'head');
                        break;

                    case 'forward':
                        li.className = ''.concat(_this.typeClass, '-content__list');
                        li.innerHTML = '<i class="fal fa-caret-left icon-left"></i>';
                        li.innerHTML += item.title;
                        li.setAttribute('role', 'forward');
                        break;

                    case 'end':
                        li.className = ''.concat(_this.typeClass, '-content__list');
                        li.innerHTML += item.title;
                        li.setAttribute('role', 'end');
                }

                return li;
            });

            _defineProperty(this, '_setPosition', function(ul, back, head, children) {
                if (back) {
                    var liBack = _this.contentLiMaker(back, 'back');

                    liBack.addEventListener('click', function() {
                        _this.handleBackEvent(liBack);
                    });
                    ul.appendChild(liBack);
                }

                if (head) {
                    var liHead = _this.contentLiMaker(head, 'head');

                    liHead.addEventListener('click', function() {
                        _this.handleHeadEvent(liHead);
                    });
                    ul.appendChild(liHead);
                }

                if (children) {
                    children.map(function(child) {
                        var liChild = '';
                        child.count == 0
                            ? (liChild = _this.contentLiMaker(child, 'end'))
                            : (liChild = _this.contentLiMaker(child, 'forward'));
                        liChild.addEventListener('click', function() {
                            _this.handleChildEvent(liChild);
                        });
                        ul.appendChild(liChild);
                    });
                }
            });

            _defineProperty(this, '_setITems', function(inputId) {
                var head =
                    _this.data.find(function(item) {
                        return item.id == inputId;
                    }) || _this.data[0];

                var id = head.id,
                    parent_id = head.parent_id;
                _this.id = id;
                var back =
                    _this.data.find(function(item) {
                        return item.id == parent_id && id != item.parent_id;
                    }) || null;

                var children = _this.data.filter(function(item) {
                    return item.parent_id == id && item.id != item.parent_id;
                });

                return {
                    back: back,
                    head: head,
                    children: children
                };
            });

            _defineProperty(this, 'renderById', function(id) {
                var _id = _this.appendNameToString(id, _this.name);

                _this.render(_id);
            });

            _defineProperty(this, 'render', function(inputId) {
                _this.contentTag.innerHTML = '';

                var ul = _this.creatorElem('ul');

                var _this$_setITems = _this._setITems(inputId),
                    back = _this$_setITems.back,
                    head = _this$_setITems.head,
                    children = _this$_setITems.children;

                _this._setPosition(ul, back, head, children);

                _this.contentTag.appendChild(ul);
            });

            this.keysMap = {
                count_child: 'count',
                child: 'count'
            };
            this.root = document.querySelector(root);
            this.name = _name;
            this.typeClass = 'ilya-menu'; // make a clone from data by ...

            if (_data) {
                this.data = _data.map(function(item) {
                    return {
                        ...item
                    };
                }); // specifying Ids to name

                this.appendNameToProp(this.data, 'id', this.name);
                this.appendNameToProp(this.data, 'parent_id', this.name);
            } // init with first init Id
            // this.Init(keysMap, initId);
        }

        _createClass(IlyaMenu, [
            {
                key: 'creatorElem',
                value: function creatorElem(element) {
                    var className =
                        arguments.length > 1 && arguments[1] !== undefined
                            ? arguments[1]
                            : null;
                    var id =
                        arguments.length > 2 && arguments[2] !== undefined
                            ? arguments[2]
                            : null;
                    var elem = document.createElement(element);
                    if (id != null) elem.id = id;
                    if (className != null) elem.className = className;
                    return elem;
                } // render and set list Item
            }
        ]);

        return IlyaMenu;
    })(); //

var IlyaSeclector =
    /*#__PURE__*/
    (function(_IlyaMenu) {
        _inherits(IlyaSeclector, _IlyaMenu);

        function IlyaSeclector(name, root) {
            var _temp, _temp2, _this2;

            var data =
                arguments.length > 2 && arguments[2] !== undefined
                    ? arguments[2]
                    : null;
            var initId =
                arguments.length > 3 && arguments[3] !== undefined
                    ? arguments[3]
                    : null;

            _classCallCheck(this, IlyaSeclector);

            typeof data == 'string'
                ? ((_temp = _this2 = _possibleConstructorReturn(
                this,
                _getPrototypeOf(IlyaSeclector).call(this, name, root, null, initId)
                )),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'initSelect',
                        function() {
                            _this2.selectTag.appendChild(
                                _this2.creatorElem(
                                    'div',
                                    ''.concat(_this2.typeClass, '-select--title')
                                )
                            );

                            var div = _this2.creatorElem(
                                'div',
                                ''.concat(_this2.typeClass, '-select--change')
                            );

                            div.textContent = 'تغییر دسته بندی';

                            _this2.selectTag.appendChild(div);

                            _this2.selectTag.addEventListener('click', function() {
                                _this2.handleSelectEvent(_this2.selectTag);
                            });
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleSelectEvent',
                        function() {
                            _this2.contentTag.classList.remove('dnone');

                            _this2.selectTag.classList.remove('gvisible');

                            // _this2.root.parentNode.children[1].classList.remove('bvisible');

                            _this2.onChangeSelect();
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleBackEvent',
                        function(item) {
                            _this2.id = item.id;
                            var pid = {
                                ..._this2.data.find(function(e) {
                                    return e.id == item.id;
                                })
                            }.parent_id; // console.log(parent_id);

                            _this2.onChange();

                            _this2.onChangeBack();

                            _this2.render(pid);
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleChildEvent',
                        function(item) {
                            var role = item.getAttribute('role');
                            if (role == 'end') return _this2.handleEndEvent(item);

                            _this2.render(item.id);

                            _this2.onChange();

                            _this2.onChangeChild();
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleEndEvent',
                        function(item) {
                            _this2.id = item.id;
                            _this2.selectTag.children[0].textContent = item.textContent;

                            _this2.contentTag.classList.add('dnone');

                            _this2.selectTag.classList.add('gvisible');

                            // _this2.root.parentNode.children[1].classList.add('bvisible');

                            _this2.onChange();

                            _this2.onChangeEnd();
                        }
                    ),
                    _defineProperty(_assertThisInitialized(_this2), 'render', function(
                        inputId
                    ) {
                        _this2.contentTag.innerHTML = '';

                        var ul = _this2.creatorElem('ul');

                        var _this2$_setITems = _this2._setITems(inputId),
                            head = _this2$_setITems.head,
                            children = _this2$_setITems.children; // console.log(inputId);
                        // console.log(children);

                        _this2.getId() == null
                            ? _this2._setPosition(ul, null, null, children)
                            : _this2._setPosition(ul, head, null, children);

                        _this2.contentTag.appendChild(ul);
                    }),
                    _temp)
                : ((_temp2 = _this2 = _possibleConstructorReturn(
                this,
                _getPrototypeOf(IlyaSeclector).call(this, name, root, data, initId)
                )),
                    (_temp = _this2 = _possibleConstructorReturn(
                        this,
                        _getPrototypeOf(IlyaSeclector).call(this, name, root, null, initId)
                    )),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'initSelect',
                        function() {
                            _this2.selectTag.appendChild(
                                _this2.creatorElem(
                                    'div',
                                    ''.concat(_this2.typeClass, '-select--title')
                                )
                            );

                            var div = _this2.creatorElem(
                                'div',
                                ''.concat(_this2.typeClass, '-select--change')
                            );

                            div.textContent = 'تغییر دسته بندی';

                            _this2.selectTag.appendChild(div);

                            _this2.selectTag.addEventListener('click', function() {
                                _this2.handleSelectEvent(_this2.selectTag);
                            });
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleSelectEvent',
                        function() {
                            _this2.contentTag.classList.remove('dnone');

                            _this2.selectTag.classList.remove('gvisible');

                            // _this2.root.parentNode.children[1].classList.remove('bvisible');

                            _this2.onChangeSelect();
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleBackEvent',
                        function(item) {
                            _this2.id = item.id;
                            var pid = {
                                ..._this2.data.find(function(e) {
                                    return e.id == item.id;
                                })
                            }.parent_id;

                            _this2.onChange();

                            _this2.onChangeBack();

                            _this2.render(pid);
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleChildEvent',
                        function(item) {
                            var role = item.getAttribute('role');
                            if (role == 'end') return _this2.handleEndEvent(item);

                            _this2.render(item.id);

                            _this2.onChange();

                            _this2.onChangeChild();
                        }
                    ),
                    _defineProperty(
                        _assertThisInitialized(_this2),
                        'handleEndEvent',
                        function(item) {
                            _this2.id = item.id;
                            _this2.selectTag.children[0].textContent = item.textContent;

                            _this2.contentTag.classList.add('dnone');

                            _this2.selectTag.classList.add('gvisible');

                            // _this2.root.parentNode.children[1].classList.add('bvisible');

                            _this2.onChange();

                            _this2.onChangeEnd();
                        }
                    ),
                    _defineProperty(_assertThisInitialized(_this2), 'render', function(
                        inputId
                    ) {
                        _this2.contentTag.innerHTML = '';

                        var ul = _this2.creatorElem('ul');

                        var _this2$_setITems = _this2._setITems(inputId),
                            head = _this2$_setITems.head,
                            children = _this2$_setITems.children;

                        _this2.getId() == null
                            ? _this2._setPosition(ul, null, null, children)
                            : _this2._setPosition(ul, head, null, children);

                        _this2.contentTag.appendChild(ul);
                    }),
                    _temp,
                    _temp2);
            _this2.typeClass = 'ilya-selector';

            if (typeof data == 'string') {
                var getAjax = async function getAjax(link) {
                    var response = await fetch(link);
                    var data = await response.json();
                    return data;
                };

                getAjax(data)
                    .then(function(data) {
                        _this2.data = data;
                    })
                    .then(function() {
                        _this2.appendNameToProp(_this2.data, 'id', _this2.name);

                        _this2.appendNameToProp(_this2.data, 'parent_id', _this2.name);

                        _this2.Init(_this2.keysMap, initId);
                    });
            } else {
                _this2.Init(_this2.keysMap, initId);
            } // console.log(this.selectTag);

            return _possibleConstructorReturn(_this2);
        }

        return IlyaSeclector;
    })(IlyaMenu);
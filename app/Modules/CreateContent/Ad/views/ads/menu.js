'use strict';

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

var input = [
  {
    id: null,
    title: 'همه',
    parent_id: null,
    count_child: 3
  },
  {
    id: 2,
    title: 'املاک',
    parent_id: null,
    count_child: 0
  },
  {
    id: 3,
    title: 'وسایل نقلیه',
    parent_id: null,
    count_child: 0
  },
  {
    id: 4,
    title: 'لوازم الکترونیکی',
    parent_id: null,
    count_child: 2
  },
  {
    id: 5,
    title: 'رایانه',
    parent_id: 4,
    count_child: 0
  },
  {
    id: 6,
    title: 'کنسول',
    parent_id: 4,
    count_child: 2
  },
  {
    id: 7,
    title: 'ps4',
    parent_id: 6,
    count_child: 0
  },
  {
    id: 8,
    title: 'xbox',
    parent_id: 6,
    count_child: 0
  }
];
var input2 = [
  {
    id: 4,
    title: 'لوازم الکترونیکی',
    parent_id: null,
    count_child: 2
  },
  {
    id: 5,
    title: 'رایانه',
    parent_id: 4,
    count_child: 0
  },
  {
    id: 6,
    title: 'کنسول',
    parent_id: 4,
    count_child: 2
  },
  {
    id: 7,
    title: 'ps4',
    parent_id: 6,
    count_child: 0
  },
  {
    id: 8,
    title: 'xbox',
    parent_id: 6,
    count_child: 0
  }
];

var SideMenu =
    /*#__PURE__*/
    (function() {
      function SideMenu(name, _root) {
        var _this = this;

        var type =
            arguments.length > 2 && arguments[2] !== undefined
                ? arguments[2]
                : 'default';
        var APILink =
            arguments.length > 3 && arguments[3] !== undefined
                ? arguments[3]
                : null;

        var _initId =
            arguments.length > 4 && arguments[4] !== undefined
                ? arguments[4]
                : null;

        var data =
            arguments.length > 5 && arguments[5] !== undefined
                ? arguments[5]
                : null;

        _classCallCheck(this, SideMenu);

        _defineProperty(this, 'baseURL', '');

        _defineProperty(this, 'setRoot', function(root) {
          _this.root = document.querySelector(root);
        });

        _defineProperty(this, 'id', '');

        _defineProperty(this, 'initMenu', function(initId) {
          var div = document.createElement('div');
          var classb = 'ilya-menu-select';
          _this.type == 'default'
              ? (div.className = classb)
              : (div.className = ''.concat(classb, 'unvisible'));

          _this.root.appendChild(div);

          _this.listMaker(_this.renderOutput(initId));

          if (_this.type != 'no_header') _this.initHeader(initId);
        });

        _defineProperty(this, 'pushHeaderText', function(input) {
          _this.headerText.push(input);
        });

        _defineProperty(this, 'popHeaderText', function() {
          _this.headerText.pop();
        });

        _defineProperty(this, 'showHeaderText', function() {
          var l = _this.headerText.length;
          var head = _this.root.children[0];

          if (l == 1 || l == 2) {
            head.textContent = _this.headerText[l - 1];
          } else if (l == 3) {
            head.textContent = _this.headerText[1] + ' >> ' + _this.headerText[2];
          } else {
            head.textContent =
                _this.headerText[1] + ' >> ... >> ' + _this.headerText[l - 1];
          }
        });

        _defineProperty(this, 'initHeader', function(id) {
          if (id == null) {
            return _this.showHeaderText();
          }

          var item = _this.data.filter(function(item) {
            return item.id == id;
          })[0];

          _this.headerText.unshift(item.title);

          _this.initHeader(item.parent_id);
        });

        _defineProperty(this, 'renderOutput', function(id) {
          var base = {
            ..._this.data.filter(function(item) {
              return item.id == id;
            })[0]
          };
          base.id = base.id + _this.name;

          var children = _this.data
              .filter(function(item) {
                return item.parent_id == id && item.id != null;
              })
              .map(function(child) {
                return { ...child };
              })
              .map(function(a) {
                return { ...a };
              });

          children.map(function(child) {
            return (child.id = child.id + _this.name);
          });
          var parent = {};
          var out = {};

          if (base.id != null) {
            if (
                _this.data.filter(function(item) {
                  return item.id == base.parent_id;
                })[0] == undefined
            ) {
              out = {
                base: base,
                parent: 'und',
                children: children
              };
              return out;
            }

            parent = {
              ..._this.data.filter(function(item) {
                return item.id == base.parent_id;
              })[0]
            };
            parent.id = base.parent_id + _this.name;
            out = {
              base: base,
              parent: parent,
              children: children
            };
            return out;
          }

          out = {
            base: base,
            parent: null,
            children: children
          };
          return out;
        });

        _defineProperty(this, 'liAndACreator', function(
            parent,
            className,
            text,
            id,
            icon,
            event
        ) {
          var li = document.createElement('li');
          li.className = className;
          li.id = id;

          if (icon == 'right') {
            li.innerHTML = '<i class="fal fa-caret-right icon-right"></i>';
          }

          if (icon == 'left') {
            li.innerHTML = '<i class="fal fa-caret-left icon-left"></i>';
          }

          li.innerHTML += text;
          li.setAttribute('role', 'option');
          li.addEventListener('click', function() {
            _this.handleMenuClick(li, event);
          });
          parent.appendChild(li);
        });

        _defineProperty(this, 'listMaker', function(input) {
          if (_this.root.children[1]) {
            _this.root.children[1].remove();
          }

          var base = input.base,
              children = input.children,
              parent = input.parent;
          var ul = document.createElement('ul');
          ul.setAttribute('ilya-show', true);
          var div = document.createElement('div');
          div.className = 'ilya-menu-content';
          div.appendChild(ul);

          _this.root.appendChild(div);

          if (parent !== 'und') {
            if (base.id[0] != 'n') {
              _this.liAndACreator(
                  ul,
                  'ilya-menu-content__back',
                  parent.title,
                  parent.id,
                  'right',
                  'back'
              );
            }
          }

          _this.liAndACreator(
              ul,
              'ilya-menu-content__header',
              base.title,
              base.id,
              null,
              'base'
          );

          children.map(function(child) {
            return _this.liAndACreator(
                ul,
                'ilya-menu-content__item',
                child.title,
                child.id,
                'left',
                'child'
            );
          });
        });

        _defineProperty(this, 'id', '');

        _defineProperty(this, 'handleMenuClick', function(input, event) {
          _this.id = input.id;

          _this.onChange();

          var id = _this.getId(); // if (id == 'n') id = null;

          if (_this.type == 'default') {
            if (event == 'back') {
              _this.popHeaderText();

              _this.showHeaderText();
            }

            if (event == 'child') {
              _this.pushHeaderText(input.textContent);

              _this.showHeaderText();
            }

            if (event == 'base') {
              return;
            }
          }

          _this.listMaker(_this.renderOutput(id));
        });

        _defineProperty(this, 'getId', function() {
          var id = (' ' + _this.id).slice(1);

          var nameLen = _this.name.length;
          var idLen = id.length;
          if (id[0] == 'n') return null;
          return id.slice(0, idLen - nameLen);
        });

        _defineProperty(this, 'onChange', function() {
          _this.callback();
        });

        this.setRoot(_root);
        this.name = name;
        this.type = type;

        if (data == null) {
          var getAjax = async function getAjax(link) {
            var response = await fetch(link);
            var data = await response.json();
            return data;
          };

          getAjax(APILink)
              .then(function(data) {
                _this.data = data;
              })
              .then(function() {
                return _this.initMenu(_initId);
              });
        } else {
          this.data = data;

          if (_initId == null) {
            this.initMenu(this.data[0].id);
          } else {
            this.initMenu(_initId);
          }
        }
      }

      _createClass(SideMenu, [
        {
          key: 'setCallback',
          value: function setCallback(call) {
            this.callback = call;
          }
        }
      ]);

      return SideMenu;
    })();

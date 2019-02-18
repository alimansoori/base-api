$(document).ready(function () {
	$('.ilya-image-thumb li').click(function () {
		$('.ilya-image-thumb li').removeClass("active-image"); // remove active class from all li 
		// $('.image-card--image').
		$(this).addClass('active-image'); // add active class for click li
		var thumbnailImg = ($(this).find('a img').attr('src'));
		($('.image-card--image img').attr('src', thumbnailImg));
	});
	// var animation = anime({
	// 	targets: '.image-card--image img',
	// 	width: '100%', // -> from '28px' to '100%',
	// 	easing: 'easeInOutQuad',
	// 	direction: 'alternate',
	// });
	// document.querySelector('.ilya-image-thumb li').onclick = animation.play;
});

const ilyaStep = num => {

	if (num >= 5 && num <= 0) return null;
	const headTag = document.querySelector('#ilya-steps');
	const contentTag = document.querySelector('#ilya-steps-content');
	Object.values(contentTag.children).map(item => {
		if (item.classList.contains('show-content'))
			item.classList.remove('show-content');
	});
	contentTag.children[num - 1].classList.add('show-content');

	Object.values(headTag.children).map((item, index) => {

		if (item.classList.contains('ilya-step-active'))
			item.classList.remove('ilya-step-active');
		if (item.classList.contains('ilya-step-visible'))
			item.classList.remove('ilya-step-visible');
		if (index < num - 1)
			item.classList.add('ilya-step-visible');
		if (index == num - 1)
			item.classList.add('ilya-step-active');


	});

}

class ilyaTab {
	constructor(name, root, data) {
		this.name = name;
		this.data = data;
		this.setRoots(root);
		this.init();
	}

	init = () => {
		// console.log(this.data.length);
		this.createSteps();
	};

	setRoots = root => {
		this.rootTag = document.querySelector(root);
		this.stepsTag = document.querySelector(`${root} .ilya-tab-steps`);
		this.contentTag = document.querySelector(`${root} .ilya-present-tab-content`);
	};

	createSteps = count => {
		const data = [...this.data];
		let ul = this.creatorElem('ul');

		data.map((item, index) => {
			let li = this.creatorElem('li', 'ilya-tab__step', item.id);

			li.textContent = item.text;
			li.addEventListener('click', () => {
				this.changeContent(item.menuId);
				this.changeStep(li);
			});

			ul.appendChild(li);

		});

		this.stepsTag.appendChild(ul);

	};

	changeStep = (li) => {
		Object.values(this.stepsTag.children[0].children)
			.map(item => {
				if (item.classList.contains('active-step'))
					item.classList.remove('active-step');
			});

		li.classList.add('active-step');

	}


	creatorElem(element, className = null, id = null) {
		let elem = document.createElement(element);
		if (id != null) elem.id = id;
		if (className != null) elem.className = className;
		return elem;

	}

	changeContent = id => {
		let allContents = Object.values(
			document.querySelector('.ilya-present-tab-content').children
		);
		allContents.map(item => {
			if (item.classList.contains('bvisible'))
				item.classList.remove('bvisible');
			// console.log(allContents);
		});
		let target = document.querySelector(`#${id}`);
		target.classList.add('bvisible');
	};

}
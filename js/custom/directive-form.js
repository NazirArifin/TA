'use strict';

/** simpan directori */
app.directive('saveDirektori', ['notify', '$http', '$timeout', function(notify, $http, $timeout) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var t = '<i class="fa fa-lg fa-check-square-o"></i> SIMPAN DATA DIREKTORI';
			var successCallback = function() {
				notify.slideTop.info('Data direktori berhasil tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$scope.activeDirektori = $scope.namaDirektori = '';
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				}
				if (status == 403 || status == 401) {
					notify.slideTop.error('Tidak ada hak akses, silakan login ulang!');
					$scope.logout();
				}
				$scope.activeDirektori = $scope.namaDirektori = '';
			};
			
			// elemen diklik
			elm.on('click', function() {
				var d = $scope.direktori,
					f = [];
				if (d.kategori === null || d.kategori == '') f.push('kategori');
				if (d.nama === null || d.nama.length < 5) f.push('nama');
				if (d.kota === null || d.kota == '') f.push('kota');
				if (d.alamat === null || d.alamat.length < 5) f.push('alamat');
				if (d.telepon === null || d.telepon.length < 3) f.push('telepon');
				if (d.info === null || d.info.length < 5) f.push('info');
				// hapus semua class has-error
				$('.form-group').removeClass('has-error');
				// jika ada yang error
				if (f.length > 0) {
					angular.forEach(f, function(value, key) {
						$('#' + value).closest('.form-group').addClass('has-error');
					});
					$("html, body").animate({ scrollTop: 0 }, "slow");
					if (f[0] == 'kategori') $('#kategori').select2('open');
					else $('#' + f[0]).focus();
					notify.bounce.error('Input tidak lengkap atau invalid. Periksa bagian bertanda kesalahan');
					return false;
				}
				$('.form-group').removeClass('has-error');
				// animasi di tombol
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				if ($scope.file !== null) {
					// upload file juga
					var fd = new FormData();
					fd.append('file', $scope.file);
					angular.forEach($scope.direktori, function(value, key) {
						if ( ! angular.isObject(value))
							fd.append(key, value);
						else {
							angular.forEach(value, function(v, k) {
								var ks = key + '[' + k + ']';
								fd.append(ks, v);
							});
						}
					});
					
					var url = '/direktori' + ($scope.direktori.id != '' ? '/' + $scope.direktori.id : '');
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback();
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					// gunakan $http
					var url = '/direktori' + ($scope.direktori.id != '' ? '/' + $scope.direktori.id : '');
					$http({ url: url, method: 'POST', data: $scope.direktori }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback();
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	};
}]);

/** simpan pendaftaran */
app.directive('saveRegister', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				var valid = true;
				if (angular.isUndefined($scope.user.email) || $scope.user.email.length == 0) {
					$('#email').closest('.form-group').addClass('has-error');
					valid = false;
				}
				if ($scope.user.nama.length < 3) {
					$('#nama').closest('.form-group').addClass('has-error');
					valid = false;
				}
				if ($scope.user.telepon.length < 8) {
					$('#telp').closest('.form-group').addClass('has-error');
					valid = false;
				}
				if (valid) {
					if ( ! $scope.user.agree) return notify.slideTop.info('Anda harus menyetujui peraturan layanan di MADURA.BZ');
				} else {
					if ( ! valid) return notify.slideTop.error('Input Tidak Lengkap, Ulangi Bagian Bertanda Kesalahan');
				}
				$('.form-group').removeClass('has-error');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/daftar', $scope.user).
				success(function(d) {
					elm.html('<i class="fa fa-check-circle-o"></i> Daftar Sekarang').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.registered = true;
						$scope.password = d.password;
						notify.slideTop.info('Selamat! Anda berhasil terdaftar');
					}
				});
			});
		}
	};
}]);

/** simpan testimoni */
app.directive('saveTestimoni', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function() {
				if ($scope.testi.length < 15) return notify.bounce.error('Testimoni dianggap terlalu sedikit!');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/testimoni', { sender: me, member: you, data: $scope.testi }).
				success(function(d) {
					elm.html('<i class="fa fa-check"></i> Tambahkan Testimoni').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.testi = '';
						$scope.loadTesti();
						notify.slideTop.info('Testimoni berhasil ditambahkan');
					} else {
						$scope.testi = '';
						notify.slideTop.error(d.data);
					}
				});
			});
		}
	};
}]);

/** simpan review **/
app.directive('saveReview', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			elm.on('click', function() {
				if ($scope.review.length < 15) return notify.bounce.error('Review produk dianggap terlalu sedikit!');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/review', { sender: member, produk: produk, data: $scope.review }).
				success(function(d) {
					elm.html('<i class="fa fa-check"></i> Tambahkan Review').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.review = '';
						$scope.loadData();
						notify.slideTop.info('Review berhasil ditambahkan');
					} else {
						$scope.review = '';
						notify.slideTop.error(d.data);
					}
				});
			});
		}
	};
}]);

/** simpan komentar **/
app.directive('saveKomentar', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			elm.on('click', function() {
				if ($scope.komentar.length < 2) return notify.bounce.error('Komentar harus terisi');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/komentar', { sender: member, post: post, data: $scope.komentar }).
				success(function(d) {
					elm.html('<i class="fa fa-check"></i> Tambahkan Komentar').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.komentar = '';
						$scope.loadData();
						notify.slideTop.info('Komentar berhasil ditambahkan');
					} else {
						$scope.komentar = '';
						notify.slideTop.error(d.data);
					}
				});
			});
		}
	};
}]);

/** simpan data kiriman */
app.directive('saveKiriman', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			var t = '<i class="fa fa-check"></i> SIMPAN KIRIMAN';
			var successCallback = function() {
				notify.slideTop.info('Data kiriman berhasil tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$scope.resetData();
				$scope.loadData();
				$scope.cancel();
				if ($scope.file !== null) $scope.file = null;
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				} else {
					if( ! status.type) notify.bounce.error(status.data);
				}
			};
			
			elm.on('click', function() {
				var b = $scope.post, f = [];
				if (b.judul === null || b.judul.length < 3) f.push('judul');
				if (b.isi === null || b.isi.length < 10) f.push('isi');
				// hapus semua class has-error
				$('.form-group').removeClass('has-error');
				if (f.length > 0) {
					angular.forEach(f, function(value, key) {
						$('#' + value).closest('.form-group').addClass('has-error');
					});
					notify.bounce.error('Input tidak lengkap atau invalid. Periksa bagian bertanda kesalahan');
					return false;
				}
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				var url = '/post' + ($scope.post.id != '' ? '/' + $scope.post.id : '');
				if ($scope.file !== null) {
					var fd = new FormData();
					if (angular.isArray($scope.file)) {
						for (var i in $scope.file) fd.append('file_' + i, $scope.file[i]);
					} else fd.append('file_0', $scope.file);
					
					angular.forEach($scope.post, function(value, key) {
						if (angular.isArray(value)) {
							for (var i in value) {
								fd.append(key + '[]', value[i]);
							}
						} else fd.append(key, value);
					});
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback(d);
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					$http({ url: url, method: 'POST', data: $scope.post }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback(d);
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	};
}]);

/** simpan data produk */
app.directive('saveProduk', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			var t = '<i class="fa fa-lg fa-check-square-o"></i> SIMPAN PRODUK';
			var successCallback = function() {
				notify.slideTop.info('Data produk berhasil tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$scope.resetProduk();
				$scope.loadData();
				$scope.cancel();
				if ($scope.file !== null) $scope.file = null;
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				}
			};
			
			elm.on('click', function() {
				var b = $scope.produk, f = [];
				if (b.kategori === null || b.kategori.length < 1) f.push('kategori');
				if (b.nama === null || b.nama.length < 3) f.push('nama');
				if (b.info === null || b.info.length < 5) f.push('info');
				if (b.harga === null || b.harga == 0) f.push('harga');
				// hapus semua class has-error
				$('.form-group').removeClass('has-error');
				if (f.length > 0) {
					angular.forEach(f, function(value, key) {
						$('#' + value).closest('.form-group').addClass('has-error');
					});
					notify.bounce.error('Input tidak lengkap atau invalid. Periksa bagian bertanda kesalahan');
					return false;
				}
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				var url = '/produk' + ($scope.produk.id != '' ? '/' + $scope.produk.id : '');
				
				if ($scope.file !== null) {
					var fd = new FormData();
					if (angular.isArray($scope.file)) {
						for (var i in $scope.file) fd.append('file_' + i, $scope.file[i]);
					} else fd.append('file_0', $scope.file);
					
					angular.forEach($scope.produk, function(value, key) {
						if (angular.isArray(value)) {
							for (var i in value) {
								fd.append(key + '[]', value[i]);
							}
						} else fd.append(key, value);
					});
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback();
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					$http({ url: url, method: 'POST', data: $scope.produk }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback();
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	}
}]);

/** simpan pesan dari modal */
app.directive('saveMessageModal', ['notify', '$http', function(notify, $http) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var $text = $('#modalInputText');
			elm.on('click', function(ev) {
				if ($text.val().length < 3) {
					$text.focus();
					return $text.closest('.form-group').addClass('has-error');
				}
				$http.post('/pesan', $scope.message).
				success(function(d) {
					$('#modal-2').removeClass('md-show');
					notify.flip.info('Pesan yang Anda kirim berhasil tersimpan');
				}).error(function(e, s, h) {
					$('#modal-2').removeClass('md-show');
					alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
				});
			});
		}
	};
}]);

/** update profil */
app.directive('saveProfil', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				var $nama = $('#profil-nama'),
					$alamat = $('#profil-alamat'),
					$telepon = $('#profil-telepon'),
					$pass1 = $('#profil-password'),
					$pass2 = $('#profil-password2');
				var valid = true,
					field = [];
				if ($nama.val().length < 3) {
					valid = false; field.push($nama);
				}
				if ($alamat.val().length < 5) {
					valid = false; field.push($alamat);
				}
				var pass1 = $pass1.val(), pass2 = $pass2.val();
				if (pass1.length > 0 && pass1.length < 6) {
					valid = false; field.push($pass1);
				}
				if (pass1 != pass2) {
					valid = false; field.push($pass2);
				}
				if ( ! valid) {
					angular.forEach(field, function(value, key) {
						value.closest('.form-group').addClass('has-error');
					});
					return notify.slideTop.error('Input tidak lengkap, ulangi bagian bertanda kesalahan!');
				} else {
					var param = {
						nama: $nama.val(), alamat: $alamat.val(), telepon: $telepon.val(),
						pass: pass1, pass2: pass2
					}, url = '/anggota/' + attrs.kode;
					if ($scope.file !== null) {
						var fd = new FormData();
						fd.append('file', $scope.file);
						angular.forEach(param, function(value, key) {
							fd.append(key, value);
						});
						var xhr = new XMLHttpRequest();
						xhr.open('POST', url, true);
						xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
						xhr.onload = function() {
							var d = angular.fromJson(this.responseText);
							if (d.type == true) window.location.reload(true);
						};
						xhr.onerror = function() {
							$('#modal-3').removeClass('md-show');
							notify.slideTop.error('Terjadi kesalahan, ulang proses!');
						};
						xhr.send(fd);
					} else {
						$http({ url: url, method: 'POST', data: param }).
						success(function(d) { 
							if (d.type == true) window.location.reload(true);
						}).
						error(function(e, s, h) {
							$('#modal-3').removeClass('md-show');
							notify.slideTop.error('Terjadi kesalahan, ulang proses!');
						});
					}
				}
			});
		}
	};
}]);

/** simpan pesanan */
app.directive('saveOrder', ['$http', 'notify', '$localStorage', function($http, notify, $localStorage) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				if ($(this).data('clicked')) {
					e.preventDefault();
					e.stopPropagation();
					return;
				}
				
				if ($scope.grandTotal == $scope.shipRate) return notify.slideTop.error('Tidak ada produk yang dipesan');
				var $nama = $('#c-nama'),
					$alamat = $('#c-alamat'),
					$telepon = $('#c-telepon');
				if ($nama.val().length < 3) {
					$nama.closest('.form-group').addClass('has-error');
					return notify.slideTop.error('Nama penerima tidak boleh kosong');
				}
				if ($alamat.val().length < 5) {
					$alamat.closest('.form-group').addClass('has-error');
					return notify.slideTop.error('Alamat penerima tidak boleh kosong');
				}
				if ($scope.shipRate == 0) return notify.slideTop.error('Pastikan kota tujuan terisi dengan benar');
				var item = [];
				angular.forEach($scope.itemList, function(value, key) {
					item.push({ id: value.id, jumlah: value.jumlah });
				});
				var data = {
					nama: $nama.val(), alamat: $alamat.val(), telepon: $telepon.val(), produk: item, ongkir: $scope.shipRate
				};
				$(this).data('clicked', true);
				$http.post('/order', data).
				success(function(d) {
					delete $localStorage.item;
					window.location.href = '/home/order';
				}).error(function(e, s, h) { alertify.error('Terjadi kesalahan'); });
			});
		}
	}
}]);

/** simpan konfirmasi order **/
app.directive('saveKonfirmasi', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				var rekening = $('#modal-4').find('.radio-input'),
					selected = false, $input = null, bank = '';
				for (var i = 0; i < rekening.length; i++) {
					$input = $(rekening[i]);
					if ($input.is(':checked')) {
						selected = true;
						bank = $input.val();
						break;
					}
				}
				if ( ! selected) {
					$input.closest('.form-group').addClass('has-error');
					return;
				} else $input.closest('.form-group').removeClass('has-error');
				$http.post('/order/konfirmasi', {
					id: $('#order-id').val(),
					pesan: $('#order-pesan').val(),
					bayar: $('#order-bayar').val(),
					rekening: bank
				}).
				success(function(d) {
					$('#modal-4').removeClass('md-show');
					notify.slideTop.warning('Konfirmasi pembayaran berhasil tersimpan. <strong>Harap tunggu beberapa waktu untuk Administrator melakukan pengecekan</strong>. Begitu pembayaran valid maka status Pemesanan Anda akan berubah');
				});
			});
		}
	};
}]);

/** simpan pesan */
app.directive('savePesan', ['$http', function($http) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				if ($scope.newMessage.length < 2) return false;
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				$http.post('/admin/pesan', { forCode: $scope.idSelected, forName: '', type: $scope.tipeSelected.toLowerCase(), message: $scope.newMessage }).
				success(function(d) {
					elm.html('<i class="fa fa-send"></i> KIRIMKAN').prop('disabled', false).addClass('btn-primary').removeClass('btn-danger');
					$scope.newMessage = '';
					$scope.loadPesanAfter();
				});
			});
		}
	};
}]);

/** simpan aduan */
app.directive('saveAduan', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				$http.post('/post/aduan', { post: attrs.saveAduan, reason: $('#report-alasan').val() }).
				success(function(d) {
					$('#modal-5').removeClass('md-show');
					if (d.data == '') 
						notify.slideTop.warning('Aduan berhasil tersimpan. Administrator akan segera diberitahu tentang aduan Anda. Terima kasih telah membantu situs ini menjadi lebih baik');
					else notify.slideTop.error(d.data);
				});
			});
		}
	};
}]);
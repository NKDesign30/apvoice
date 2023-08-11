/* eslint-disable no-param-reassign */
import DownloadsService from '@/services/api/DownloadsService';
import {
  DOWNLOADS_FETCH_ALL,
  DOWNLOADS_FETCH_ONE,
  DOWNLOADS_FETCH_DOWNLOAD_MEDIATYPES, // Hinzugefügt
} from '../types/action-types';
import {
  DOWNLOADS_UPDATE_DOWNLOADS,
  DOWNLOADS_UPDATE_CURRENT_DOWNLOAD,
  SET_MEDIA_TYPES, // Hinzugefügt
} from '../types/mutation-types';

export default {
  state: {
    downloads: [],
    currentDownload: {},
    mediaTypes: [], // Hinzugefügt
  },

  mutations: {
    [DOWNLOADS_UPDATE_DOWNLOADS](state, updatedDownloads) {
      state.downloads = updatedDownloads;
    },
    [SET_MEDIA_TYPES](state, mediaTypes) {
      console.log('In der Mutation SET_MEDIA_TYPES:', mediaTypes); // Diesen Log hinzufügen
      state.mediaTypes = mediaTypes;
    },
    [DOWNLOADS_UPDATE_CURRENT_DOWNLOAD](state, updatedCurrentDownload) {
      state.currentDownload = updatedCurrentDownload;
    },
  },

  actions: {
    [DOWNLOADS_FETCH_ALL]({ dispatch, commit, state }) {
      if (state.downloads.length === 0) {
        dispatch('wait/start', 'downloads', { root: true });
      }

      return new Promise((resolve, reject) => {
        DownloadsService.fetchAll()
          .then(downloads => {
            commit(DOWNLOADS_UPDATE_DOWNLOADS, downloads);
            dispatch('wait/end', 'downloads', { root: true });
            resolve(downloads);
          }).catch(reject);
      });
    },
    [DOWNLOADS_FETCH_ONE]({ dispatch, commit }, id) {
      dispatch('wait/start', 'download', { root: true });

      return new Promise((resolve, reject) => {
        DownloadsService.fetch(id)
          .then(download => {
            commit(DOWNLOADS_UPDATE_CURRENT_DOWNLOAD, download);
            dispatch('wait/end', 'download', { root: true });
            resolve(download);
          }).catch(reject);
      });
    },
    async [DOWNLOADS_FETCH_DOWNLOAD_MEDIATYPES]({ commit }) {
      try {
        console.log('DOWNLOADS_FETCH_DOWNLOAD_MEDIATYPES Aktion wird aufgerufen');
        const mediaTypes = await DownloadsService.fetchDownloadMediatypes();
        console.log('Abgerufene Medientypen12:', mediaTypes);
        commit(SET_MEDIA_TYPES, mediaTypes);
      } catch (error) {
        console.error('Fehler beim Abrufen der Medientypen:', error);
      }
    },
  },

  getters: {
    downloads(state) {
      return state.downloads;
    },
    currentDownload(state) {
      return state.currentDownload;
    },
    downloadById(state) {
      return id => state.downloads.find(download => download.id === id);
    },
    mediaTypes(state) { // Hinzugefügt
      return state.mediaTypes;
    },
  },
};
